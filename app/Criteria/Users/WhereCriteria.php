<?php

namespace App\Criteria\Users;

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
    protected $cmp;

    /**
     * WhereCriteria constructor.
     * @param $col
     * @param $value
     * @param string $cmp
     */
    public function __construct($col, $value, $cmp = '=')
    {
        $this->col = $col;
        $this->value = $value;
        $this->cmp = $cmp;
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
        $model = $model->where($this->col, $this->cmp, $this->value);

        return $model;
    }
}
