<?php

namespace App\Http\Controllers\Front;

use App\Contactos;
use App\Productos;
use App\Materiales;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Front\SubirFotoRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Front\GuardarContactoRequest;

class HomeController extends AppBaseController
{
    use FileUploadTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function proximamente() {
        if (auth()->check()) {
            auth()->logout();
        }
        $this->data['gracias'] = [
            'titulo' => 'Pr&oacute;ximamente',
            'subtitulo' => 'Te esperamos el 1ro de Diciembre'
        ];
        return view('front.gracias', ['data' => $this->data]);
    }

    public function index()
    {
        if (config('constantes.homeActiva',true)) {
            $this->data['cambiarPassword'] = [
                'form' => [
                    'password' => null,                
                ],
                'enviando' => false,
                'enviado' => false,
                'url_post' => route('miCuenta.cambiarPassword'),
            ];
            $this->data['guardarContacto'] = [
                'form' => [
                    'mensaje' => null,                
                    'registrado_id' => auth()->user()->id
                ],
                'enviando' => false,
                'enviado' => false,
                'url_post' => route('guardarContacto'),
            ];            
            $this->data['registrado'] = auth()->user()->load([
                'sucursal.retail.banner',
                'sucursal.retail.premio',
                'sucursal.retail.mecanica' => function($q) {
                    $q->whereEnabled(true);
                }
            ]);
            $this->data['productos'] = Productos::whereEnabled(true)->orderBy('orden')->get();

            $sucursal = $this->data['registrado']->sucursal;

            $dataEstadisticaSucursal = $this->obtenerEstadisticasActuales($sucursal->id);

            if ($sucursal->retail->tipo === 'I') {
                $dataEstadisticaSucursal['target_attach'] = (float)$sucursal->target_attach;
                $dataEstadisticaSucursal['minimo_un_cumplir'] = (int)$sucursal->piso_unidades_office;
                $this->data['ranking'] = GeneralHelper::rankingIndividual($sucursal->retail->id);
            } else {
                $campoTa = 'cat_' . $sucursal->categoria_cluster . '_target_attach';
                $campoPuo = 'cat_' . $sucursal->categoria_cluster . '_puo';
                $dataEstadisticaSucursal['target_attach'] = (float)$sucursal->retail->$campoTa;
                $dataEstadisticaSucursal['minimo_un_cumplir'] = (int)$sucursal->retail->$campoPuo;
                
                $this->data['ranking'] = GeneralHelper::rankingCluster($sucursal->retail->id,$sucursal->categoria_cluster);
                
            }
            $dataEstadisticaSucursal['actual_attach'] = $dataEstadisticaSucursal['cantidad_dispositivos'] > 0 ? ($dataEstadisticaSucursal['cantidad_office']/$dataEstadisticaSucursal['cantidad_dispositivos']) * 100 : 0;

            $this->data['estadisticas'] = $dataEstadisticaSucursal;
            $this->data['ventas'] = GeneralHelper::ventasPorSucursal($sucursal->id);
            $this->data['subirFoto'] = [
                'form' => [
                    'archivo' => null,                
                    'registrado_id' => auth()->user()->id,
                ],
                'enviando' => false,
                'enviado' => false,
                'url_post' => route('subirFoto'),
            ];             
            return view('front.home', ['data' => $this->data]);
    
        } else {
            return view('front.gracias', ['data' => $this->data]);
        }


    }

    public function guardarContacto (GuardarContactoRequest $request) 
    {
        try {
            
            if (auth()->user()->id == $request->registrado_id) {
                DB::beginTransaction();
                $contacto = new Contactos;
                $contacto->fill($request->all());
                $contacto->save();

                DB::commit();
                return $this->sendResponse($contacto,'Gracias por dejarnos tu mensaje.'); 
            }
            throw new \Exception("No es el mismo registrados", 1);
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->sendError($e->getMessage(),$e->getCode());
        }
    }

    protected function obtenerEstadisticasActuales ($sucursalId) {
        $sql = "SELECT s.id, SUM(cantidad_dispositivos) cantidad_dispositivos, SUM(ventas_cant.cantidad) cantidad_office
            FROM ventas v
            INNER JOIN sucursales s ON v.sucursal_id = s.id
            INNER JOIN (
                SELECT venta_id, SUM(cantidad) cantidad 
                FROM ventas_productos
                GROUP BY venta_id
            ) ventas_cant ON ventas_cant.venta_id = v.id	
            WHERE s.id = {$sucursalId}   
            AND v.deleted_at IS NULL 
            GROUP BY s.id";

        $data = \DB::select($sql);

        if (count($data) > 0) {
            return [
                'cantidad_dispositivos' => (int)$data[0]->cantidad_dispositivos,
                'cantidad_office' => (int)$data[0]->cantidad_office
            ];            
        } else {
            return [
                'cantidad_dispositivos' => 0,
                'cantidad_office' => 0
            ];
        }
        
    }

    public function subirFoto (SubirFotoRequest $request) 
    {
        try {
            
            if (auth()->user()->id == $request->registrado_id) {
                DB::beginTransaction();
                
                $file = $this->saveFile($request,'archivo','tmp');
                if ($file) {
                    $foto = new Materiales();
                    $foto->tipo = 'R';
                    $foto->sucursal_id = auth()->user()->sucursal_id;
                    $foto->imagen = $file;
                    $foto->user_id = 1;
                    
                    $foto->save();
                    \Log::info($foto);
                }
                DB::commit();
                return $this->sendResponse([],'Gracias por dejarnos tu mensaje.'); 
            }
            throw new \Exception("No es el mismo registrado", 1);
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());
            return $this->sendError($e->getMessage(),$e->getCode());
        }
    }
}
