<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\Retails;
use Illuminate\Http\Request;
use App\Repositories\PremiosRepository;
use App\Http\Requests\Admin\CUPremiosRequest;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;

class PremiosController extends CrudAdminController
{
    protected $routePrefix = 'premios';
    protected $viewPrefix  = 'admin.premios.';
    protected $actionPerms = 'premios';

    public function __construct(PremiosRepository $repo)
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
            $collection = $this->repository->with(['updater','retail.pais'])->paginate($request->get('per_page'))->toArray();        

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

        $this->data['selectedItem']->load('retail');

        return view($this->viewPrefix.'show')->with('data', $this->data);
    }

    public function create()
    {
        parent::create();

        data_set($this->data, 'selectedItem', [
            'id' => 0,
            'retail_id' => null,
            'descripcion' => '',
            'imagen_web' => null,
            'imagen_web_url' => null,
            'imagen_mobile' => null,
            'imagen_mobile_url' => null,
        ]);

        data_set($this->data,'info',[
            'retails' => Retails::with('pais')->doesnthave('premio')->orderBy('pais_id')->orderBy('nombre')->get()
        ]);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CUPremiosRequest $request)
    {
        $model = $this->_store($request);
        return $this->sendResponse($model,trans('admin.success'));        
    }

    public function edit($id)
    {
        parent::edit($id);
        $this->data['selectedItem']->load('retail.pais');
        if (!$this->data['selectedItem']->descripcion) {
            $this->data['selectedItem']->descripcion = '';
        }
        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUPremiosRequest $request)
    {
        $model = $this->_update($id, $request);

        return $this->sendResponse($model,trans('admin.success'));
    }
}
