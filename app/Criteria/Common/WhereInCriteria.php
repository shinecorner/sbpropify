<?php

namespace App\Criteria\Common;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WhereCriteria
 * @package App\Criteria\Users
 */
class WhereInCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    protected $col;

    /**
     * @var
     */
    protected $values;

    /**
     * @var string
     */
    protected $operator;

    /**
     * WhereInCriteria constructor.
     * @param $col
     * @param null $values
     */
    public function __construct($col, $values = null)
    {
        $this->col = $col;
        $this->values = $values;
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
        $this->values = (array) $this->values;
        $model = $model->whereIn($this->col, $this->values);

        return $model;
    }
}
