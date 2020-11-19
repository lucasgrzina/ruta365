<?php

namespace App\Http\Controllers\Admin;

use DB;
use Response;
use App\Paises;
use App\Productos;
use App\Sucursales;
use Illuminate\Http\Request;
use App\Repositories\VentasRepository;
use App\Http\Requests\Admin\CUVentasRequest;
use App\Repositories\Criteria\VentasCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;

class VentasController extends CrudAdminController
{
    protected $routePrefix = 'ventas';
    protected $viewPrefix  = 'admin.ventas.';
    protected $actionPerms = 'ventas';

    public function __construct(VentasRepository $repo)
    {
        $this->repository = $repo;

        //$this->middleware('permission:ver-'.$this->actionPerms, ['only' => ['index','filter','show']]);        
        //$this->middleware('permission:editar-'.$this->actionPerms, ['only' => ['create','store','edit','update','destroy']]);          
    }

    public function index()
    {
        parent::index();

        if (auth()->user()->hasAnyRole(['Comprador','Marketing Manager'])) {
            $owner = true;
            $sucursales = Sucursales::whereRetailId(auth()->user()->retail_id)->whereEnabled(true)->get();
        } else {
            $owner = false;
            $sucursales = [];
        }

        $this->data['owner'] = $owner;
        $this->data['filters']['pais_id'] = null;
        $this->data['filters']['retail_id'] = $owner ? auth()->user()->retail_id : null;
        $this->data['filters']['sucursal_id'] = null;

        $this->data['info'] = [
            'productos' => Productos::whereEnabled(true)->orderBy('orden', 'asc')->get(),
            'paises' => Paises::whereEnabled(true)->orderBy('nombre')->get(),
            'retails' => [],
            'sucursales' => $sucursales
        ];



        return view($this->viewPrefix.'index')->with('data',$this->data);
    }

    public function filter(Request $request)
    {
        try
        {
            $this->repository->pushCriteria(new RequestCriteria($request));
            $this->repository->pushCriteria(new VentasCriteria($request));
            $collection = $this->repository->with(['updater', 'sucursal', 'productos'])->paginate($request->get('per_page'))->toArray();        

            $this->data = [
                'list' => $collection['data'],
                'paging' => array_only($collection,['total','current_page','last_page'])
            ];   

        }
        catch (\Exception $ex) 
        {
            return $this->sendError($ex->getMessage(),500);
        } 

        return $this->sendResponse($this->data, trans('admin.success'));
    }

    public function show($id)
    {
        parent::show($id);

        //$this->data['selectedItem']->load('xxx');


        return view($this->viewPrefix.'show')->with('data', $this->data);
    }

    public function create()
    {
        parent::create();

        $productos          = Productos::whereEnabled(true)->orderBy('orden', 'asc')->get();
        $ventasProductos    = [];

        foreach ($productos as $producto) {
           array_push($ventasProductos, [
                'id'            => 0,
                'venta_id'      => 0,
                'producto_id'   => $producto->id,
                'producto'      => $producto,
                'cantidad'      => 0
           ]);
        }

        data_set($this->data, 'selectedItem', [
                'id'                    => 0,
                'cantidad_dispositivos' => 0,
                'productos'             => $ventasProductos
        ]);

        data_set($this->data,'info',[
            'sucursales'    => Sucursales::whereRetailId(auth()->user()->retail_id)->whereEnabled(true)->get(),
           // 'productos'     => Productos::whereEnabled(true)->orderBy('orden', 'asc')->get()
        ]); 

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CUVentasRequest $request)
    {
        try {
            $input      = $request->except(['productos']);
            $productos  = $request->productos;
    
            \DB::beginTransaction();
    
            $model = $this->_store($input,true);

            foreach ($productos as $producto) {
        
                if (Productos::whereId($producto['id'])->count() > 0) {
                    $model->productos()->update($producto['id'], $producto);  
                }else{
                    $model->productos()->create(array_except($producto, ['producto']));
                }
            }

            //\Log::info($request->all());
            //throw new \Exception("Error Processing Request", 1);
            
            \DB::commit();
            return $this->sendResponse($model,trans('admin.success'));        
        } catch(\Exception $ex) {
            \DB::rollback();
            return $this->sendError($ex->getMessage(),500);

        }       
    }

    public function edit($id)
    {
        parent::edit($id);
        
        $sucursal = Sucursales::find($this->data['selectedItem']->sucursal_id);

        data_set($this->data,'info',[
            'sucursales'    => Sucursales::whereRetailId($sucursal->retail_id)->whereEnabled(true)->get()
        ]); 

        $ventasGuardas = $this->data['selectedItem']->load('productos.producto');

        //dd($ventasGuardas->productos[0]->venta_id);

        $this->data['selectedItem'] = $this->data['selectedItem']->toArray();

        $productos          = Productos::whereEnabled(true)->orderBy('orden', 'asc')->get();
        $ventasProductos    = [];

        
        foreach ($productos as $producto) {
            $productExist = false;

            for ($i=0; $i < count($ventasGuardas->productos); $i++) { 
                if($producto['id'] == $ventasGuardas->productos[$i]['producto_id'] ){
                    $productExist = true;
                    array_push($ventasProductos, $ventasGuardas->productos[$i]);
                }else if ($ventasGuardas->productos[$i]['cantidad'] > 0){
                    $productExist = true;
                }
            }

            if (!$productExist){
                array_push($ventasProductos, [
                    'id'            => 0,
                    'venta_id'      => 0,
                    'producto_id'   => $producto->id,
                    'producto'      => $producto,
                    'cantidad'      => 0
                ]);
            }
        }

        $this->data['selectedItem']['productos'] = $ventasProductos;

        
        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUVentasRequest $request)
    {
        try {    
            DB::beginTransaction();
    
            $model = $this->_update($id, $request, true);

            foreach ($request->productos as $producto) {
                if ($producto['id'] > 0) {
                    DB::table('ventas_productos')
                ->where('id', $producto['id'])
                ->update(['cantidad' => $producto['cantidad']]);
                }else{
                    if($producto['cantidad'] > 0){
                        $model->productos()->create(array_except($producto, ['producto']));
                    }
                }
            }

            DB::commit();
            return $this->sendResponse($model,trans('admin.success'));        

        } catch(\Exception $ex) {
            \DB::rollback();
            return $this->sendError($ex->getMessage(),500);
        }        
        
        return $this->sendResponse($model,trans('admin.success'));
    }
}
