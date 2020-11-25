<?php

namespace App\Http\Controllers\Admin;

use App\Categoria;
use Carbon\Carbon;
use App\Configuraciones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
use App\Sucursales;
use App\Retails;
use App\Paises;

class DashboardController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = $this->config('*');
        $data = [
            'config' => $config,
            'url_save' => route('admin.home.guardar')
        ];

        
        if (auth()->user()->hasAnyRole(['Comprador','Marketing Manager'])) {
            
            $user       = auth()->user()->id;
            $sucursales = Sucursales::whereRetailId(auth()->user()->retail_id)->whereEnabled(true)->get();
            $retail     = Retails::find(auth()->user()->retail_id);

            $retaildata = [
                'nombre'    => $retail->nombre,
                'pais'      => Paises::find($retail->pais_id)->nombre
            ];

            $data['user'] = [
                'id'            => auth()->user()->id,
                'nombre'        => auth()->user()->nombre,
                'apellido'      => auth()->user()->apellido,
                'sucursales'    => $sucursales,
                'retail'        => $retaildata
            ];

        }
        return view('admin.dashboard',['data' => $data]);
    }

    public function guardar(Request $request) {

        foreach ($request->config as $key => $value) {
            \Log::info($key);
            if ($key == 'encuesta') {
                $value = $value ? true : false;
            }
            Configuraciones::where('clave',$key)->update(['valor' => $value]);
        }

        //Configuraciones::where('clave','encuesta')->update(['valor' => $request->encuesta]);
        return $this->sendResponse($request->all(),trans('admin.success'));        
    }

    protected function config($clave='*') {
        if ($clave === '*') {
            return Configuraciones::pluck('valor','clave');
        } else {
            return Configuraciones::whereClave($clave)->first()->valor;    
        }
    }


    public function exportar() {
        
        $disk = 'dist';
        $configStorage = config('filesystems.disks.'.$disk);

        $carpetasBorrar = [];
        $carpetasExistentes = \Storage::disk($disk)->allDirectories();
        foreach ($carpetasExistentes as $carpeta) {
            $carpetaExp = explode('/',$carpeta);
            if (count($carpetaExp) === 2 && $carpetaExp[1] === 'productos') {
                $carpetasBorrar[] = $carpetaExp[0];
            }
        }

        
        $menuCategorias = [];

        foreach($this->categorias()->get() as $cat) {
            $secciones = $cat->secciones->pluck('nombre','id');
            $menuCategorias[] = [
                'id' => $cat->id,
                'nombre' => $cat->nombre,
                'secciones' => $secciones
            ];
        }

        $contenido = $this->contenido();
        
        $carpetaAssets = time().'/';
        $carpetaAssetsProductos = $carpetaAssets.'productos/';
        $carpetaAssetsEstaticos = 'static/';

        foreach ($contenido as $cat) {
            foreach ($cat->secciones as $sec) {
                foreach ($sec->productos as $prod) {
                    \Storage::disk($disk)->put(
                        $carpetaAssetsProductos.$prod->imagen, 
                        \Storage::disk('uploads')->get('productos/'.$prod->imagen),
                        $configStorage['driver'] === 's3' ? 'public-read' : null
                    );
                }
            }
        }

        
        $assetsEstaticos = [
            'css','js','img','fonts'
        ];

        foreach ($assetsEstaticos as $folder) {
            $files = \Storage::disk('assets')->files($folder);
            foreach ($files as $file) {
                \Storage::disk($disk)->put(
                    $carpetaAssetsEstaticos.$file, 
                    \Storage::disk('assets')->get($file),
                    $configStorage['driver'] === 's3' ? 'public-read' : null
                );
            }
        }

        
        $html = \View::make('front.home', compact([
            'menuCategorias',
            'contenido',
            'carpetaAssets',
            'carpetaAssetsProductos',
            'carpetaAssetsEstaticos'
        ]));
        
        
        
        \Storage::disk($disk)->put('index.html', $html->render(), $configStorage['driver'] === 's3' ? 'public-read' : null);

        foreach ($carpetasBorrar as $carpeta) {
            \Storage::disk($disk)->deleteDirectory($carpeta);
        }
        return  \Storage::disk($disk)->allFiles();

    }

    public function previsualizar() {
        
        
        $menuCategorias = [];

        foreach($this->categorias()->get() as $cat) {
            $secciones = $cat->secciones->pluck('nombre','id');
            $menuCategorias[] = [
                'id' => $cat->id,
                'nombre' => $cat->nombre,
                'secciones' => $secciones
            ];
        }

        $contenido = $this->contenido();
        
        $carpetaAssets = time().'/';
        $carpetaAssetsProductos = \FUHelper::fullUrl('productos','/');
        $carpetaAssetsEstaticos = asset('/');
        
        $html = \View::make('front.home', compact([
            'menuCategorias',
            'contenido',
            'carpetaAssetsEstaticos',
            'carpetaAssets',
            'carpetaAssetsProductos'
        ]));
        
        return $html;
        
    }    

    protected function categorias() {
        return Categoria::with(['secciones' => function($q) {
            $q->orderBy('orden');
        }])->whereHas('secciones', function ($q) {
            $q->whereHas('productos',function($q) {
                $q->whereEnabled(true);
            })->whereEnabled(true);
        })->whereEnabled(true)->orderBy('orden');
    }

    protected function contenido() {
        $data = $this->categorias()->with([
            'secciones' => function($q) {
                $q->orderBy('orden')->whereEnabled(true);
            },
            'secciones.productos' => function($q) {
                $q->orderBy('orden')->whereEnabled(true);
            }
        ])->get();

        return $data;
    }
    
    public function unauthorized()
    {
        return view('admin.unauthorized');
    }    

    
}
