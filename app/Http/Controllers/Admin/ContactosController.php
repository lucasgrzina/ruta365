<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudAdminController;
use App\Http\Requests\Admin\CUContactosRequest;
use App\Repositories\ContactosRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ContactosController extends CrudAdminController
{
    protected $routePrefix = 'contactos';
    protected $viewPrefix  = 'admin.contactos.';
    protected $actionPerms = 'contactos';

    public function __construct(ContactosRepository $repo)
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
            $collection = $this->repository->with(['updater','registrado.sucursal.retail.pais'])->paginate($request->get('per_page'))->toArray();        

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

        $model = $this->data['selectedItem'];
        $model->leido = true;
        $model->save();
        
        $this->data['selectedItem']->load('registrado.sucursal.retail.pais');

        return view($this->viewPrefix.'show')->with('data', $this->data);
    }

    public function create()
    {
        return redirect()->back();
        parent::create();

        data_set($this->data, 'selectedItem', [
                'id' => 0,
        ]);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CUContactosRequest $request)
    {
        $model = $this->_store($request);
        return $this->sendResponse($model,trans('admin.success'));        
    }

    public function edit($id)
    {
        parent::edit($id);
        $model = $this->data['selectedItem'];
        $model->leido = true;
        $model->save();

        $this->data['selectedItem']->load('registrado.sucursal.retail.pais');
        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUContactosRequest $request)
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
