<?php

namespace App\Repositories;

use App\Models\RealEstate;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager as Image;

/**
 * Class RealEstateRepository
 * @package App\Repositories
 * @version February 1, 2019, 9:23 pm UTC
 *
 * @method RealEstate findWithoutFail($id, $columns = ['*'])
 * @method RealEstate find($id, $columns = ['*'])
 * @method RealEstate first($columns = ['*'])
*/
class RealEstateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'phone',
        'language'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RealEstate::class;
    }

    // TODO: move function to media repository
    public function uploadImage(string $fileData, RealEstate $realEstate, $fileName = null)
    {
        $fileName = $fileName ?? Str::slug(sprintf('%s-%d', $realEstate->name, $realEstate->id)) . '.png';
        $imgPath = storage_path(sprintf('app/public/%s', $fileName));

        (new Image)->make($fileData)->encode('png', 65)->save($imgPath);

        return sprintf('storage/%s', $fileName);
    }
}
