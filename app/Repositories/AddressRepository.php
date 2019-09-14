<?php

namespace App\Repositories;

use App\Models\Address;

/**
 * Class AddressRepository
 * @package App\Repositories
 * @version January 27, 2019, 7:35 pm UTC
 *
 * @method Address findWithoutFail($id, $columns = ['*'])
 * @method Address find($id, $columns = ['*'])
 * @method Address first($columns = ['*'])
*/
class AddressRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city',
        'street',
        'house_nr',
        'zip'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Address::class;
    }
    public function create(array $attributes)
    {
        if (isset($attributes['state'])) {
            $attributes['state_id'] = $attributes['state']['id'];
            unset($attributes['state']);
        }
        unset($attributes['country']);
        $attributes['country_id'] = $attributes['country_id'] ?? \App\Models\Country::where('name', 'Switzerland')->value('id');

        return parent::create($attributes);
    }

    public function update(array $attributes, $id)
    {
        if (isset($attributes['state'])) {
            $attributes['state_id'] = $attributes['state']['id'];
            unset($attributes['state']);
        }
        unset($attributes['country']);

        return parent::update($attributes, $id);
    }
}
