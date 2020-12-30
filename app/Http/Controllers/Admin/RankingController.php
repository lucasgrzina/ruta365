<?php

namespace App\Http\Controllers\Admin;

use App\Retails;
use App\Categoria;
use Carbon\Carbon;
use App\Configuraciones;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppBaseController;

class RankingController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($retailId = null)
    {

        $tablaRanking = [];
        $categorias = [];

        if (!auth()->user()->hasAnyRole(['Comprador','Marketing Manager']) && !$retailId) {
            return redirect()->route('admin.home');
        } else if (auth()->user()->hasAnyRole(['Comprador','Marketing Manager'])) {
            $retailId = auth()->user()->retail_id;
        }

        $retail = Retails::find($retailId);
        if ($retail->tipo === 'I') {
            // Individual
            
            $tablaRanking = GeneralHelper::rankingIndividual($retailId);
        } else {
            // Clusters
            $categorias = $retail->sucursales()->distinct('categoria_cluster')->pluck('categoria_cluster')->toArray();
        }


        $data = [
            'retail' => $retail,
            'tabla' => $tablaRanking,
            'categorias' => $categorias,
            'loading' => false,
            'categoria' => null,
            'url_ranking_categoria' => route('admin.ranking.categoria',['_CAT_'])
        ];
        return view('admin.ranking',['data' => $data]);
    }

    public function rankingCategoria($idCategoria) {

        $retailId = auth()->user()->retail_id;
        $data = GeneralHelper::rankingCluster($retailId,$idCategoria);
        return $this->sendResponse($data,trans('admin.success')); 
    }
    
    public function rankingRetail($idRetail) {

        $data = GeneralHelper::rankingIndividual($idRetail);
        return $this->sendResponse($data,trans('admin.success')); 
    }

    public function unauthorized()
    {
        return view('admin.unauthorized');
    }    

    
}
