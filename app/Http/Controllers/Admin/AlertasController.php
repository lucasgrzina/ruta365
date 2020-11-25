<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\Paises;
use App\Sucursales;
use Illuminate\Http\Request;
use App\Repositories\AlertasRepository;
use App\Http\Requests\Admin\CUAlertasRequest;
use App\Repositories\Criteria\AlertasCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;

class AlertasController extends CrudAdminController
{
    protected $routePrefix = 'alertas';
    protected $viewPrefix  = 'admin.alertas.';
    protected $actionPerms = 'alertas';

    public function __construct(AlertasRepository $repo)
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
        $this->data['filters']['leido'] = null;

        $this->data['info'] = [
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
            $this->repository->pushCriteria(new AlertasCriteria($request));
            $collection = $this->repository->with(['updater','usuario','sucursal.retail.pais'])->paginate($request->get('per_page'))->toArray();        

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
        
        
        if (!auth()->user()->hasAnyRole(['Comprador','Marketing Manager'])) {
            $model = $this->data['selectedItem'];
            $model->leido = true;
            $model->save();
        }

        $this->data['selectedItem']->load(['usuario','sucursal.retail.pais']);

        return view($this->viewPrefix.'show')->with('data', $this->data);
    }

    public function create()
    {
        parent::create();

        if (!auth()->user()->hasAnyRole(['Comprador','Marketing Manager'])) {
            throw new \Exception('No puedes realizar esta acción');
        } else {
            $owner = true;
        }

        
        data_set($this->data, 'selectedItem', [
                'id' => 0,
                'user_id' => auth()->user()->id,
                'usuario' => auth()->user(),
                'sucursal_id' => null,
                'descripcion' => null,
                'leido' => false,
                'observaciones' => null
        ]);

        $this->data['owner'] = $owner;

        data_set($this->data,'info',[
            'sucursales' => Sucursales::whereRetailId(auth()->user()->retail_id)->whereEnabled(true)->get()
        ]);        

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CUAlertasRequest $request)
    {
        $model = $this->_store($request->except('usuario'));
        return $this->sendResponse($model,trans('admin.success'));        
    }

    public function edit($id)
    {
        parent::edit($id);
        
        $this->data['selectedItem']->load(['usuario','sucursal.retail.pais']);
        
        if (auth()->user()->hasAnyRole(['Comprador','Marketing Manager'])) {            
            $owner = true;
        } else {
            $owner = false;
            $model = $this->data['selectedItem'];
            $model->leido = true;
            $model->save();
    
        }    


        $this->data['owner'] = $owner;

        data_set($this->data,'info',[
            'sucursales' => Sucursales::whereRetailId(auth()->user()->retail_id)->whereEnabled(true)->get()
        ]);          
        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUAlertasRequest $request)
    {
        $model = $this->_update($id, $request);

        return $this->sendResponse($model,trans('admin.success'));
    }

    public function changeEnabled(Request $request)
    {
        $input = [
            'leido' => $request->leido
        ];

        $model = $this->repository->findWithoutFail($request->get('id'));

        if (empty($model)) {
            return $this->sendError(trans('admin.not_found'));
        }

        $model = $this->repository->update($input, $request->get('id'));

        $this->clearCache();

        return $this->sendResponse(null,trans('admin.success'));
    }     
}
