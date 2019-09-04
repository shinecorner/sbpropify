<?php

namespace App\Criteria\ServiceProviders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Post;

/**
 * Class FilterByStateCriteria
 * @package App\Criteria\ServiceProviders
 */
class FilterByStateCriteria implements CriteriaInterface
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
        $stateId = $this->request->get('state_id', null);
        if (!$stateId) { return $model; }

        $model->join('loc_addresses', 'loc_addresses.id', '=', 'service_providers.address_id')
            ->where('loc_addresses.state_id', $stateId);

        return $model;
    }
}
