<?php

namespace App\Http\Controllers\Front;

use App\Contactos;
use App\Productos;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Front\GuardarContactoRequest;

class HomeController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        if (config('constantes.homeActiva',true)) {
            $this->data['cambiarPassword'] = [
                'form' => [
                    'password' => null,                
                ],
                'enviando' => false,
                'enviado' => false,
                'url_post' => route('miCuenta.cambiarPassword'),
            ];
            $this->data['guardarContacto'] = [
                'form' => [
                    'mensaje' => null,                
                    'registrado_id' => auth()->user()->id
                ],
                'enviando' => false,
                'enviado' => false,
                'url_post' => route('guardarContacto'),
            ];            
            $this->data['registrado'] = auth()->user()->load([
                'sucursal.retail.banner',
                'sucursal.retail.premio',
                'sucursal.retail.mecanica' => function($q) {
                    $q->whereEnabled(true);
                }
            ]);
            $this->data['productos'] = Productos::whereEnabled(true)->orderBy('orden')->get();
            return view('front.home', ['data' => $this->data]);
    
        } else {
            return view('front.gracias', ['data' => $this->data]);
        }

    }

    public function guardarContacto (GuardarContactoRequest $request) 
    {
        try {
            
            if (auth()->user()->id == $request->registrado_id) {
                DB::beginTransaction();
                $contacto = new Contactos;
                $contacto->fill($request->all());
                $contacto->save();

                DB::commit();
                return $this->sendResponse($contacto,'Gracias por dejarnos tu mensaje.'); 
            }
            throw new \Exception("No es el mismo registrados", 1);
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->sendError($e->getMessage(),$e->getCode());
        }
    }
}
