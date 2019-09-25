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
class WhereCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    protected $col;

    /**
     * @var
     */
    protected $value;

    /**
     * @var string
     */
    protected $operator;

    /**
     * WhereCriteria constructor.
     * @param $col
     * @param null $operator
     * @param null $value
     */
    public function __construct($col, $operator = null, $value = null)
    {
        $this->col = $col;
        $this->value = $value;
        $this->operator = $operator;
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
        $model = $model->where($this->col, $this->operator, $this->value);

        return $model;
    }
}
