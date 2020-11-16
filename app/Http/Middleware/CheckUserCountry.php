<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserCountry
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        /*$valid = $request->session()->get('valid');
               
        if(!isset($valid) || $valid==false) {
           
            $response = $this->checkCountry("https://geodude.api.cloud.telefe.com/capabilities/europa");
            
            if($response == "\"false\"") {
                $valid = true;
            }else{
                $valid = false;
            }
            
            $request->session()->put('valid', $valid);
            
        }
        
        if($valid) {
            if(\Cookie::get('viacom_country') == null) {
                $response = $this->checkCountry("https://geodude.api.cloud.telefe.com/capabilities/eeuu");
                
                if($response == "\"true\"" ) {
                    app()->setLocale("en");
                    \Cookie::queue(\Cookie::make('viacom_country', 'en', 518400));
                }else{
                    $response = $this->checkCountry("https://geodude.api.cloud.telefe.com/capabilities/brasil");
                    
                    if($response == "\"true\"") {
                        app()->setLocale("pt");
                        \Cookie::queue(\Cookie::make('viacom_country', 'pt', 518400));
                    }else{
                        app()->setLocale("es");
                        \Cookie::queue(\Cookie::make('viacom_country', 'es', 518400));
                        
                    }
                }
            } else {
                app()->setLocale(\Cookie::get('viacom_country'));
            }
            
            return $next($request);
        } else {
            return redirect()->url('http://www.viacom.com');
        }*/
        
        return $next($request);
    }
    
    private function checkCountry($url) {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        
        $err = curl_error($curl);
        curl_close($curl);
        
        return $response;
    }
}