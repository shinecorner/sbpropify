<?php

namespace App\Repositories;

use App\Models\Settings;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager as Image;

/**
 * Class SettingsRepository
 * @package App\Repositories
 * @version February 1, 2019, 9:23 pm UTC
 *
 * @method Settings findWithoutFail($id, $columns = ['*'])
 * @method Settings find($id, $columns = ['*'])
 * @method Settings first($columns = ['*'])
*/
class SettingsRepository extends BaseRepository
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
        return Settings::class;
    }

    // TODO: move function to media repository
    public function uploadImage(string $fileData, Settings $settings, $fileName = null)
    {
        $fileName = $fileName ?? Str::slug(sprintf('%s-%d', $settings->name, $settings->id)) . '.png';
        $imgPath = storage_path(sprintf('app/public/%s', $fileName));

        (new Image)->make($fileData)->encode('png', 65)->save($imgPath);

        return sprintf('storage/%s', $fileName);
    }
}
