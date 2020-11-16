<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\Retails;
use Illuminate\Http\Request;
use App\Repositories\MecanicasRepository;
use App\Http\Requests\Admin\CUMecanicasRequest;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;

class MecanicasController extends CrudAdminController
{
    protected $routePrefix = 'mecanicas';
    protected $viewPrefix  = 'admin.mecanicas.';
    protected $actionPerms = 'mecanicas';

    public function __construct(MecanicasRepository $repo)
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

        $this->data['selectedItem']->load('retail.pais');

        return view($this->viewPrefix.'show')->with('data', $this->data);
    }

    public function create()
    {
        parent::create();

        data_set($this->data, 'selectedItem', [
            'id' => 0,
            'retail_id' => null,
            'cuerpo' => '',
        ]);
        data_set($this->data,'info',[
            'retails' => Retails::doesnthave('mecanica')->get()
        ]);
        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CUMecanicasRequest $request)
    {
        $model = $this->_store($request);
        return $this->sendResponse($model,trans('admin.success'));        
    }

    public function edit($id)
    {
        parent::edit($id);
        $this->data['selectedItem']->load('retail.pais');
        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUMecanicasRequest $request)
    {
        $model = $this->_update($id, $request);

        return $this->sendResponse($model,trans('admin.success'));
    }
}
