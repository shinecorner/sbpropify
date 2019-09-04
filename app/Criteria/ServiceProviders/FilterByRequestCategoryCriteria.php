<?php

namespace App\Criteria\ServiceProviders;

use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByBuildingCriteria
 * @package App\Criteria\ServiceProviders
 */
class FilterByRequestCategoryCriteria implements CriteriaInterface
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
        $categoryId = $this->request->get('category_id', null);
        if (!$categoryId) { return $model; }

        $type = get_morph_type_of(ServiceProvider::class);
        $model->join('request_assignees', 'request_assignees.assignee_id', '=', 'service_providers.id')
            ->join('service_requests', 'service_requests.id', '=', 'request_assignees.request_id')
            ->where('request_assignees.assignee_type', $type)
            ->where('category_id', $categoryId);

        return $model;
    }
}
