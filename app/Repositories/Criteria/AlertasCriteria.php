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
class AlertasCriteria implements CriteriaInterface
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
        $retailId = null;
        if (auth()->user()->hasAnyRole(['Comprador','Marketing Manager'])) {
            // Es un usuario de un retail, solo debe ver su retail
            $retailId = auth()->user()->retail_id;
        }

        if ($retailId === null) {
            $retailId = $this->request->get('retail_id',null);
        }

        if ($retailId !== null) {
            $model->whereHas('sucursal', function ($q) use($retailId){
                $q->whereRetailId($retailId);
            });
        }

        if ($this->request->has('sucursal_id') && $this->request->get('sucursal_id',null) !== null)
        {
            $model->where('sucursal_id',$this->request->sucursal_id);
        }


        if ($this->request->has('leido') && $this->request->get('leido',null) !== null)
        {
            $model->where('leido',$this->request->leido);
        }

        return $model;
    }
}
