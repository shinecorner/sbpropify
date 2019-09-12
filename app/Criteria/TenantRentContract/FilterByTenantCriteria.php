<?php

namespace App\Criteria\TenantsRentContract;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByTenantCriteria
 * @package App\Criteria\TenantsRentContract
 */
class FilterByTenantCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param         Builder|Model     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {      
        $unit_id = $this->request->get('tenant_id', null);
        if ($unit_id) {
            return $model->where('tenant_id', (int)$unit_id);
        }
        
        return $model;     
    }  
}
