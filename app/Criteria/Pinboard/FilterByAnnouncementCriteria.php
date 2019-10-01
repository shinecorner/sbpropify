<?php

namespace App\Criteria\Pinboard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByAnnouncementCriteria
 * @package App\Criteria\Pinboard
 */
class FilterByAnnouncementCriteria implements CriteriaInterface
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
        if ($this->request->has('announcement')) {
            $announcement = $this->request->get('announcement');
        } elseif ($this->request->has('pinned')) { // @TODO delete
            $announcement = $this->request->get('pinned');// @TODO delete
        } else {
            return $model;
        }

        return $model->where('announcement', $announcement);
    }
}
