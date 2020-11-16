<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\Clientes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Imports\GeneralImport;
use Illuminate\Support\Facades\DB;
use App\Repositories\ClientesRepository;
use App\Http\Requests\Admin\CUClientesRequest;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;

class ClientesController extends CrudAdminController
{
    protected $routePrefix = 'clientes';
    protected $viewPrefix  = 'admin.clientes.';
    protected $actionPerms = 'clientes';

    public function __construct(ClientesRepository $repo)
    {
        $this->repository = $repo;

        $this->middleware('permission:ver-'.$this->actionPerms, ['only' => ['index','filter','show']]);        
        $this->middleware('permission:editar-'.$this->actionPerms, ['only' => ['create','store','edit','update','destroy']]);          
    }

    public function index()
    {
        parent::index();
        data_set($this->data, 'url_importar', route($this->routePrefix . '.importar'));
        return view($this->viewPrefix.'index')->with('data',$this->data);
    }

    public function filter(Request $request)
    {
        try
        {
            $this->repository->pushCriteria(new RequestCriteria($request));
            $collection = $this->repository->with('updater')->paginate($request->get('per_page'))->toArray();        

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

        data_set($this->data, 'selectedItem', [
                'id' => 0
        ]);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CUClientesRequest $request)
    {
        $model = $this->_store($request);
        return $this->sendResponse($model,trans('admin.success'));        
    }

    public function edit($id)
    {
        parent::edit($id);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CUClientesRequest $request)
    {
        $model = $this->_update($id, $request);

        return $this->sendResponse($model,trans('admin.success'));
    }

    public function importar()
    {
        parent::create();

        data_set($this->data, 'selectedItem', [
            'file' => null,
            'file_url' => null
        ]);
        data_set($this->data, 'url_importar_archivo', route($this->routePrefix . '.importar-archivo'));
        return view($this->viewPrefix . 'importar')->with('data', $this->data);
    }

    public function importarArchivo(Request $request)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        $disk = 'uploads';
        $tmpDir = '/tmp';
        $file = $request->file;

        $data = (new GeneralImport)->toCollection($tmpDir . '/' . $file, 'uploads');
        $sheet = $data[0];

        $cuitsXls = $sheet->pluck('cuit')->toArray();

        $cuitsDb = Clientes::whereIn('cuit', $cuitsXls)->pluck('id', 'cuit')->toArray();


        $paraInsertar = [];
        $paraActualizar = [];

        try {
            DB::beginTransaction();

            foreach ($data[0] as $row) {
                if (array_key_exists((string)$row['cuit'], $cuitsDb)) {
                    //Para actualizar
                    /*Clientes::whereId($cuitsDb[$row['cuit']])->update([
                        'razon_social' => $cuitsDb[strtolower($row['marca'])],
                        'descripcion' => $row['descripcion']
                    ]);*/
                } else {

                    $paraInsertar[] = [
                        'cuit' => str_ireplace('-','',$row['cuit']),
                        'razon_social' => $row['razon_social'],
                        'nombre_fantasia' => $row['nombre_fantasia'],
                        'observaciones' => $row['observaciones'],
                        'created_at' => Carbon::now()
                    ];
                }
            
            }

            if (count($paraInsertar) > 0) {
                Clientes::insert($paraInsertar);
            }
            //throw new \Exception('Error Processing Request', 1);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->sendError($ex->getMessage(), 500);
        }

        return $this->sendResponse($data, trans('admin.success'));
    }    
}
