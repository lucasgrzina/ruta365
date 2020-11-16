<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\Retails;
use Illuminate\Http\Request;
use App\Repositories\SucursalesRepository;
use App\Http\Requests\Admin\CUSucursalesRequest;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;
use App\Http\Controllers\Admin\CrudAdminParentController;

class RetailsSucursalesController extends CrudAdminParentController
{
    protected $routePrefix = 'retailsSucursales';
    protected $viewPrefix  = 'admin.sucursales.';
    protected $actionPerms = 'sucursales';

    public function __construct(SucursalesRepository $repo)
    {
        $this->repository = $repo;

        $this->middleware('permission:ver-'.$this->actionPerms, ['only' => ['index','filter','show']]);        
        $this->middleware('permission:editar-'.$this->actionPerms, ['only' => ['create','store','edit','update','destroy']]);          
    }

    public function index($parentId)
    {
        parent::index($parentId);

        return view($this->viewPrefix.'index')->with('data',$this->data);
    }

    public function filter($parentId,Request $request)
    {
        try
        {
            $this->repository->pushCriteria(new RequestCriteria($request));
            $collection = $this->repository->with(['updater','retail'])->scopeQuery(function($q) use($parentId){
                return $q->whereRetailId($parentId);
            })->paginate($request->get('per_page'))->toArray();        

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

    
    public function show($parentId,$id)
    {
        parent::show($id);

        //$this->data['selectedItem']->load('xxx');

        return view($this->viewPrefix.'show')->with('data', $this->data);
    }

    public function create($parentId)
    {
        parent::create($parentId);

        $parent = Retails::find($parentId);
        
        data_set($this->data, 'selectedItem', [
                'id' => 0,
                'retail_id' => $parentId,
                'retail' => $parent,
                'codigo' => null,
                'nombre' => null,
                'observaciones' => null,
                'categoria_cluster' => 0,
                'target_attach' => 0,
                'piso_unidades_office' => 0
        ]);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store($parentId,CUSucursalesRequest $request)
    {
        $model = $this->_store($request->except('retail'));
        return $this->sendResponse($model,trans('admin.success'));        
    }

    public function edit($parentId,$id)
    {
        parent::edit($parentId,$id);
        $this->data['selectedItem']->load(['retail']);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUSucursalesRequest $request)
    {
        $model = $this->_update($id, $request);

        return $this->sendResponse($model,trans('admin.success'));
    }
   
}
