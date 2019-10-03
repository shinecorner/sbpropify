<?php

namespace App\Repositories;

use App\Models\RequestCategory;

/**
 * Class RequestCategoryRepository
 * @package App\Repositories
 * @version February 27, 2019, 2:18 pm UTC
 *
 * @method RequestCategory findWithoutFail($id, $columns = ['*'])
 * @method RequestCategory find($id, $columns = ['*'])
 * @method RequestCategory first($columns = ['*'])
*/
class RequestCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => 'like',
        'parent_id' => 'like',
        'name' => 'like',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RequestCategory::class;
    }
}
