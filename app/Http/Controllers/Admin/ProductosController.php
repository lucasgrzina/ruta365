<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\Productos;
use Illuminate\Http\Request;
use App\Repositories\ProductosRepository;
use App\Http\Requests\Admin\CUProductosRequest;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;

class ProductosController extends CrudAdminController
{
    protected $routePrefix = 'productos';
    protected $viewPrefix  = 'admin.productos.';
    protected $actionPerms = 'productos';

    public function __construct(ProductosRepository $repo)
    {
        $this->repository = $repo;

        $this->middleware('permission:ver-'.$this->actionPerms, ['only' => ['index','filter','show']]);        
        $this->middleware('permission:editar-'.$this->actionPerms, ['only' => ['create','store','edit','update','destroy']]);          
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
            $collection = $this->repository->with(['updater'])->paginate($request->get('per_page'))->toArray();        

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

        $maxOrden = Productos::max('orden');

        data_set($this->data, 'selectedItem', [
                'id' => 0,
                'nombre' => null,
                'imagen' => null,
                'imagen_url' => null,
                'orden' => $maxOrden ? $maxOrden + 1 : 1 
        ]);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CUProductosRequest $request)
    {
        $model = $this->_store($request);
        return $this->sendResponse($model,trans('admin.success'));        
    }

    public function edit($id)
    {
        parent::edit($id);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUProductosRequest $request)
    {
        $model = $this->_update($id, $request);

        return $this->sendResponse($model,trans('admin.success'));
    }
}
