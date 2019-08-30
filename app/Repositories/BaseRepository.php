<?php

namespace App\Repositories;

use App\Models\Model;
use Prettus\Repository\Events\RepositoryEntityUpdated;

abstract class BaseRepository extends \InfyOm\Generator\Common\BaseRepository
{
    /**
     * @param string $collectionName
     * @param string $dataBase64
     * @param Model $model
     * @return bool
     */
    public function uploadFile(string $collectionName, string $dataBase64, Model $model)
    {
        if (!$data = base64_decode($dataBase64)) {
            return false;
        }

        $file = finfo_open();
        $mimeType = finfo_buffer($file, $data, FILEINFO_MIME_TYPE);
        finfo_close($file);

        if (!isset($this->mimeToExtension[$mimeType])) {
            return false;
        }
        $extension = $this->mimeToExtension[$mimeType];

        $diskName = $model->getDiskPreName() . $collectionName;;

        $media = $model->addMediaFromBase64($dataBase64)
            ->sanitizingFileName(function ($fileName) use ($extension) {
                return sprintf('%s.%s', str_slug($fileName), $extension);
            })
            ->toMediaCollection($collectionName, $diskName);

        return $media;
    }

    public function doesntHave($relation)
    {
        $this->model = $this->model->doesntHave($relation);
        return $this;
    }

    public function count()
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->count();

        $this->resetModel();
        $this->resetScope();
        return $this->parserResult($results);
    }

    public function scope($scopeName)
    {
        $this->model = $this->model->{$scopeName}();
        return $this;
    }

    public function updateRelations($model, $attributes)
    {
        // @TODO if need
        return $model;
    }

    /**
     * @param Model $model
     * @param $attributes
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function updateExisting(Model $model, $attributes)
    {
        $model = $this->updateRelations($model, $attributes);
        $model->fill($attributes);
        $model->save();
        $this->resetModel();
        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }
}
