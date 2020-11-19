<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudAdminController;
use App\Http\Requests\Admin\CUVentasRequest;
use App\Repositories\VentasRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Sucursales;
use App\Productos;
use DB;

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
        return view($this->viewPrefix.'index')->with('data',$this->data);
    }

    public function filter(Request $request)
    {
        try
        {
            $this->repository->pushCriteria(new RequestCriteria($request));
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
        
        data_set($this->data,'info',[
            'sucursales'    => Sucursales::whereRetailId(auth()->user()->retail_id)->whereEnabled(true)->get()
        ]); 

        $this->data['selectedItem']->load('productos.producto');

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUVentasRequest $request)
    {
        try {    
            DB::beginTransaction();
    
            $model = $this->_update($id, $request, true);

            foreach ($request->productos as $producto) {
                DB::table('ventas_productos')
                ->where('id', $producto['id'])
                ->update(['cantidad' => $producto['cantidad']]);
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
