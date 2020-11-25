<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Response;
use App\Paises;
use Carbon\Carbon;
use App\Sucursales;
use Illuminate\Http\Request;
use App\Imports\GeneralImport;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use App\Repositories\RetailsRepository;
use App\Http\Requests\Admin\CURetailsRequest;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\Admin\CrudAdminController;

class RetailsController extends CrudAdminController
{
    protected $routePrefix = 'retails';
    protected $viewPrefix  = 'admin.retails.';
    protected $actionPerms = 'retails';

    public function __construct(RetailsRepository $repo)
    {
        $this->repository = $repo;

        $this->middleware('permission:ver-'.$this->actionPerms, ['only' => ['index','filter','show']]);        
        $this->middleware('permission:editar-'.$this->actionPerms, ['only' => ['create','store','edit','update','destroy']]);          
    }

    public function index()
    {
        parent::index();
        data_set($this->data, 'url_importar', route($this->routePrefix . '.importar-sucursales',['_ID_']));
        data_set($this->data, 'url_sucursales', route('retailsSucursales.index',['_ID_']));
        data_set($this->data, 'url_objetivos', route($this->routePrefix . '.objetivos',['_ID_']));
        return view($this->viewPrefix.'index')->with('data',$this->data);
    }

    public function filter(Request $request)
    {
        try
        {
            $this->repository->pushCriteria(new RequestCriteria($request));
            $collection = $this->repository->with(['updater','pais'])->paginate($request->get('per_page'))->toArray();        

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

        $this->data['selectedItem']->load(['pais','usuarios.roles']);

        return view($this->viewPrefix.'show')->with('data', $this->data);
    }

    public function create()
    {
        parent::create();

        $rolComprador = Role::whereName('Comprador')->first();
        $rolMkt = Role::whereName('Marketing Manager')->first();

        data_set($this->data, 'selectedItem', [
                'id' => 0,
                'nombre' => null,
                'logo' => null,
                'logo_url' => null,
                'color_hexa' => null,
                'enabled' => true,
                'pais_id' => null,
                'pais' => null,
                'usuarios' => [
                    ['id' => 0, 'nombre' => null, 'apellido' => null,'email' => null,'password' => null, 'role_id' => $rolComprador->id, 'role' => $rolComprador],
                    ['id' => 0, 'nombre' => null, 'apellido' => null,'email' => null,'password' => null, 'role_id' => $rolMkt->id, 'role' => $rolMkt]
                ]
        ]);

        data_set($this->data, 'info', [
            'paises' => Paises::whereEnabled(true)->orderBy('nombre')->get()
        ]);

        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function store(CURetailsRequest $request, UserRepository $userRepo)
    {
        try {
            $input = $request->except(['pais','usuarios']);
            $usuarios = $request->usuarios;
    
            DB::beginTransaction();
    
            $model = $this->_store($input,true);

            foreach ($usuarios as $usuario) {
                
                if ($usuario['nombre'] && $usuario['apellido'] && $usuario['email'] && $usuario['password']) {
                    if (User::whereEmail($usuario['email'])->count() > 0) {
                        throw new \Exception("Ya hay un usuario con el email " . $usuario['email'], 1);    
                    }
                    $usuario['retail_id'] = $model->id;
                    $userModel = $userRepo->create($usuario);
        
                    $role = Role::whereId($usuario['role_id'])->firstOrFail();            
                    $userModel->assignRole($role); //Assigning role to user
                    
                } else {
                    if ($usuario['nombre'] || $usuario['apellido'] || $usuario['email'] || $usuario['password']) {
                        throw new \Exception("La información del {$usuario['role']['name']} debe estar completa", 1);
                    }
    
                }

            }

            DB::commit();
            return $this->sendResponse($model,trans('admin.success'));        
        } catch(\Exception $ex) {
            \DB::rollback();
            return $this->sendError($ex->getMessage(),500);

        }
        
    }

    public function edit($id)
    {
        parent::edit($id);
        $this->data['selectedItem']->load(['usuarios.roles']);

        $rolComprador = Role::whereName('Comprador')->first();
        $rolMkt = Role::whereName('Marketing Manager')->first();

        $usuarioComprador = ['id' => 0, 'nombre' => null, 'apellido' => null,'email' => null,'password' => null, 'role_id' => $rolComprador->id, 'role' => $rolComprador];
        $usuarioMkt = ['id' => 0, 'nombre' => null, 'apellido' => null,'email' => null,'password' => null, 'role_id' => $rolMkt->id, 'role' => $rolMkt];


        foreach ($this->data['selectedItem']->usuarios as $usuario) {
            $rolId = $usuario->roles->first()->id;
            $auxUsuario = [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'email' => $usuario->email
            ];
            
            if ($rolId == $rolComprador->id) {
                $usuarioComprador = array_merge($usuarioComprador,$auxUsuario);    
            } else if ($rolId == $rolMkt->id) {
                $usuarioMkt = array_merge($usuarioMkt,$auxUsuario);    
            }
        }

        $this->data['selectedItem'] = $this->data['selectedItem']->toArray();

        $this->data['selectedItem']['usuarios'] = [
            $usuarioComprador,
            $usuarioMkt
        ];

        data_set($this->data, 'info', [
            'paises' => Paises::whereEnabled(true)->orderBy('nombre')->get()
        ]);
        return view($this->viewPrefix.'cu')->with('data',$this->data);
    }

    public function update($id, CURetailsRequest $request,UserRepository $userRepo)
    {
        try {
            $input = $request->except(['pais','usuarios']);
            $usuarios = $request->usuarios;
            
    
            DB::beginTransaction();
    
            $model = $this->_update($id, $input,true);

            foreach ($usuarios as $usuario) {

                if ($usuario['id']) {
                    if (!$usuario['nombre'] || !$usuario['apellido'] || !$usuario['email']) {
                        throw new \Exception("La información del {$usuario['role']['name']} debe estar completa", 1);
                    }                    
                    if (User::where('id','!=',$usuario['id'])->whereEmail($usuario['email'])->count() > 0) {
                        throw new \Exception("Ya hay un usuario con el email " . $usuario['email'], 1);    
                    }
                    $userModel = $userRepo->update(array_except($usuario,['password']),$usuario['id']);    

                    if ($usuario['password']) {
                        $userModel->password = $usuario['password'];
                        $userModel->save();
                    }
    
                } else {
                    if ($usuario['nombre'] && $usuario['apellido'] && $usuario['email'] && $usuario['password']) {
                        if (User::whereEmail($usuario['email'])->count() > 0) {
                            throw new \Exception("Ya hay un usuario con el email " . $usuario['email'], 1);    
                        }
                        $usuario['retail_id'] = $model->id;
                        $userModel = $userRepo->create($usuario);
            
                        $role = Role::whereId($usuario['role_id'])->firstOrFail();            
                        $userModel->assignRole($role); //Assigning role to user
                        
                    } else {
                        if ($usuario['nombre'] || $usuario['apellido'] || $usuario['email'] || $usuario['password']) {
                            throw new \Exception("La información del {$usuario['role']['name']} debe estar completa", 1);
                        }
        
                    }
                }

            }

            //throw new \Exception("Error Processing Request", 1);
            
            DB::commit();
            return $this->sendResponse($model,trans('admin.success'));        
        } catch(\Exception $ex) {
            \DB::rollback();
            return $this->sendError($ex->getMessage(),500);

        }


        //return $this->sendResponse($model,trans('admin.success'));
    }

    public function importarSucursales($id)
    {
        parent::create();

        data_set($this->data, 'selectedItem', [
            'file' => null,
            'file_url' => null
        ]);
        data_set($this->data, 'url_importar_archivo', route($this->routePrefix . '.importar-archivo',[$id]));
        return view($this->viewPrefix . 'importar-sucursales')->with('data', $this->data);
    }

    public function importarArchivo($id,Request $request)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 0);

        $disk = 'uploads';
        $tmpDir = '/tmp';
        $file = $request->file;

        $data = (new GeneralImport)->toCollection($tmpDir . '/' . $file, 'uploads');
        $sheet = $data[0];

        $codigosXls = $sheet->pluck('codigo')->toArray();

        $codigosDb = Sucursales::whereRetailId($id)->whereIn('codigo', $codigosXls)->pluck('id', 'codigo')->toArray();


        $paraInsertar = [];
        $paraActualizar = [];

        try {
            DB::beginTransaction();

            foreach ($data[0] as $row) {
                $codigo = trim($row['codigo']);
                if (array_key_exists((string)$codigo, $codigosDb)) {
                    //Para actualizar
                    Sucursales::whereId($codigosDb[$codigo])->update([
                        'nombre' => trim($row['nombre']),
                        //'observaciones' => $row['observaciones'],
                        'target_attach' => $row['target_attach'] ? (float)$row['target_attach'] : 0,
                        'piso_unidades_office' => $row['piso_unidades_office'] ? (int)$row['piso_unidades_office'] : 0,
                        'categoria_cluster' => $row['categoria_cluster'] ? (int)$row['categoria_cluster'] : 0,
                    ]);
                } else {
                    if (trim($row['codigo'])) {
                        $paraInsertar[] = [
                            'codigo' => str_ireplace('-','',trim($row['codigo'])),
                            'retail_id' => $id,
                            'nombre' => trim($row['nombre']),
                            //'observaciones' => $row['observaciones'],
                            'target_attach' => $row['target_attach'] ? (float)$row['target_attach'] : 0,
                            'piso_unidades_office' => $row['piso_unidades_office'] ? (int)$row['piso_unidades_office'] : 0,
                            'categoria_cluster' => $row['categoria_cluster'] ? (int)$row['categoria_cluster'] : 0,
                            'created_at' => Carbon::now()
                        ];
    
                    }
                }
            
            }

            if (count($paraInsertar) > 0) {
                Sucursales::insert($paraInsertar);
            }
            //throw new \Exception('Error Processing Request', 1);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->sendError($ex->getMessage(), 500);
        }

        return $this->sendResponse($data, trans('admin.success'));
    }    
    
    public function objetivos($id)
    {
        
        $model = $this->repository->with(['sucursales'])->find($id);
        
        data_set($this->data, 'selectedItem', $model);
        data_set($this->data, 'url_index', route($this->routePrefix . '.index'));
        data_set($this->data, 'url_save', route($this->routePrefix . '.guardar-objetivos',[$model->id]));
        return view($this->viewPrefix.'objetivos')->with('data',$this->data);
    }   
    
    public function guardarObjetivos($id,Request $request)
    {
        try {

            $sucursales = $request->sucursales;

            $model = $this->repository->find($id);

            if ($model->tipo === 'C') {
                $datos = [
                    'piso_unidades_office' => 0,
                    'target_attach' => 0
                ];
            } else {
                $datos = [
                    'categoria_cluster' => 0
                ];
            }
            DB::beginTransaction();
            foreach ($sucursales as $sucursal) {
                $data = array_merge(
                    array_only($sucursal,['piso_unidades_office','target_attach','categoria_cluster']),
                    $datos
                );
                Sucursales::whereId($sucursal['id'])->update($data);
            }
            DB::commit();
            return $this->sendResponse([], trans('admin.success'));
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->sendError('aaa', 500);
        }

        
        
    }      
}
