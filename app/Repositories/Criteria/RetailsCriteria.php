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
class RetailsCriteria implements CriteriaInterface
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
            $model->whereId($retailId);
        }

        if ($this->request->has('pais_id') && $this->request->get('pais_id',null) !== null)
        {
            $model->where('pais_id',$this->request->pais_id);
        }

        return $model;
    }
}
