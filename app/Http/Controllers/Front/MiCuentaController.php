<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Registrado;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Repositories\RegistradoRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Front\CambiarPasswordRequest;
use App\Http\Requests\Front\MiCuentaMisDatosGuardarRequest;

class MiCuentaController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repoRegistrados = null;

    public function __construct(RegistradoRepository $repoRegistrados)
    {
        //$this->middleware('auth:admin');
        $this->repoRegistrados = $repoRegistrados;
    }

    public function index()
    {
        $this->data['miCuenta'] = [
        ];
        return view('front.mi-cuenta.index', ['data' => $this->data]);
    }

    public function login()
    {
        $this->data['login'] = [
            'vista' => 'login',
            'form' => [
                'email' => null,
                'password' => null,
            ],
            'formRecuperar' => [
                'email' => null,
            ],
            'enviando' => false,
            'enviado' => false,
            'url_post' => route('login-post'),
            'url_post_recuperar' => route('olvide-password')
        ];
        return view('front.login', ['data' => $this->data]);
    }

    public function registro()
    {
        $this->data['registro'] = [
            'form' => [
                'nombre' => null,
                'apellido' => null,
                'email' => null,
                'password' => null,
                'pais_id' => null,
                'retail_id' => null,
                'sucursal_id' => null,
            ],
            'enviando' => false,
            'enviado' => false,
            'url_post' => route('registro-post'),
            'info' => [
                'paises' => GeneralHelper::paises(),
                'retails' => [],
                'sucursales' => []
            ]
        ];
        return view('front.registro', ['data' => $this->data]);
    }

    public function cambiarPassword(CambiarPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $registrado = auth()->user();
            $registrado->password = $request->password;
            $registrado->save();   
            DB::commit();
            return $this->sendResponse(['message' => 'Tu contraseña fué modificada con éxito.'],''); 
        } catch (\Exception $e) {
            DB::rollback();
            $this->sendError($e->getMessage(),$e->getCode());
        }

    }


    public function confirmarCuenta($guid) {

        $registrado = Registrado::where(\DB::raw('md5(id)'),$guid)->first();
        
        if (!$registrado) {
            //
        }
        
        if ($registrado && !$registrado->confirmado) {
            $registrado->confirmado = true;
            $registrado->save();
        }

        Auth::login($registrado);

        return redirect()->route('home');

    }

    public function registroGracias() {
        if (auth()->check()) {
            auth()->logout();
        }
        $this->data['gracias'] = [
            'titulo' => 'Muchas gracias',
            'subtitulo' => ('En los próximos minutos validaremos los datos de registro y te enviaremos un email a tu casilla de correo.<br>Si no encuentras el mail en la bandeja de entrada, por favor chequea en la bandeja de correo no deseado y Spam.<br><br>Si tienes alguna duda o consulta, nos puedes escribir a <a style="color:#fff;text-decoration:underline;" href="mailto:contacto@ruta365.live">contacto@ruta365.live</a>')
        ];
        return view('front.gracias', ['data' => $this->data]);
    }    
}
