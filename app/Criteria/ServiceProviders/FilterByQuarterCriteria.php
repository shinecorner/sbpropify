<?php

namespace App\Criteria\ServiceProviders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Post;

/**
 * Class FilterByQuarterCriteria
 * @package App\Criteria\ServiceProviders
 */
class FilterByQuarterCriteria implements CriteriaInterface
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
        $quarter_id = $this->request->get('quarter_id', null) ?? $this->request->get('district_id', null);
        if (!$quarter_id) { return $model; }

        $model->join('quarter_service_provider', 'quarter_service_provider.service_provider_id', '=', 'service_providers.id')
            ->where('quarter_service_provider.quarter_id', $quarter_id);

        return $model;
    }
}
