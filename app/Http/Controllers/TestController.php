<?php

namespace App\Http\Controllers;


use App\Services\ApiRolService;

use App\Services\ApiSmsService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TestController extends AppBaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function sms(ApiSmsService $smsService) {
        try
        {
            return $smsService->enviarCodigo('11','34290838');
            
        }
        catch(\Exception $ex)
        {
            \Log::info($ex->getMessage());
        }
    }
    public function rolLogin(ApiRolService $rolService) {
        try
        {
            
            $respuesta = $rolService->login();
            return $this->sendResponse($respuesta, trans('admin.success'));
            
        }
        catch(\Exception $ex)
        {
            \Log::info($ex->getMessage());
        }
    }
    public function rolConsultarInforme(ApiRolService $rolService) {
        try
        {
            $respuesta = $rolService->consultarInforme('23300075169');
            return $this->sendResponse($respuesta, trans('admin.success'));            
        }
        catch(\Exception $ex)
        {
            \Log::info($ex->getMessage());
        }
    }    
    public function rolSolicitarInforme(ApiRolService $rolService) {
        try
        {
            $respuesta = $rolService->solicitarInforme('23300075169');
            return $this->sendResponse($respuesta, trans('admin.success'));            
        }
        catch(\Exception $ex)
        {
            \Log::info($ex->getMessage());
        }
    }     
}