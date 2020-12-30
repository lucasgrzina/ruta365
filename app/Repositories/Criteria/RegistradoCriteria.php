<?php

namespace App\Repositories\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AdCriteria.
 *
 * @package namespace App\Repositories\Criteria;
 */
class RegistradoCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $paisId = $this->request->get('pais_id',null);
        $retailId = $this->request->get('retail_id',null);
        $sucursalId = $this->request->get('sucursal_id',null);

        if ($this->request->has('enabled') && $this->request->get('enabled',null) !== null)
        {
            $enabled = $this->request->get('enabled');
            $enabled = $enabled != 'P' ? $enabled : null;
            $model->where('enabled',$enabled);
        }


        if ($retailId !== null || $paisId !== null) {
            $model->whereHas('sucursal', function ($q) use($retailId,$paisId){
                if ($retailId !==null) {
                    $q->whereRetailId($retailId);
                } else {
                    $q->whereHas('retail', function($q) use($retailId,$paisId) {
                        $q->wherePaisId($paisId);
                    });
                }
                
            });
        }

        if ($this->request->has('sucursal_id') && $this->request->get('sucursal_id',null) !== null)
        {
            $model->where('sucursal_id',$this->request->sucursal_id);
        }

 
        return $model;
    }
}
