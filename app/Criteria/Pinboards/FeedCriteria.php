<?php

namespace App\Criteria\Pinboards;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FeedCriteria
 * @package Prettus\Repository\Criteria
 */
class FeedCriteria implements CriteriaInterface
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
        if ($this->request->get('feed')) {
            return $model
                ->whereRaw("(pinboards.pinned = ? or (pinboards.pinned_to is not null and pinboards.pinned_to > now()))", false)
                ->orderBy('pinboards.pinned', 'desc')
                ->orderBy('pinboards.execution_start', 'asc')
                ->orderBy('pinboards.published_at', 'desc')
                ->orderBy('pinboards.created_at', 'desc');
        }

        return $model->orderBy('pinboards.created_at', 'desc');
    }
}
