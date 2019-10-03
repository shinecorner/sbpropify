<?php

namespace App\Criteria\Listing;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByUserCriteria
 * @package Prettus\Repository\Criteria
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
        $tenant_id = $this->request->get('tenant_id', null);
        // @TODO ask use this one or nested relation criteria
//        $user_id = Tenant::where('id', $tenant_id)->value('user_id');
//        if ($user_id) {
//            $model->where('products.user_id', $user_id);
//        }
        if ($tenant_id) {
            $model->whereHas('user', function($q) use ($tenant_id) {
                $q->whereHas('tenant', function($q)  use ($tenant_id) {
                    $q->where('id', $tenant_id);
                });
            });
        }

        return $model;
    }
}
