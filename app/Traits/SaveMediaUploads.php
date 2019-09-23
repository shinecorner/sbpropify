<?php

namespace App\Traits;

trait SaveMediaUploads
{
    public function saveMediaUploads(\App\Models\Model $model, $data, $disableAuditing = false)
    {
        if (empty($data['media'])) {
            return $model;
        }
        $media = $data['media'];
        if (is_string($media)) {
            $media = [
                $media
            ];
        }

        $audit = $model->relationExists('audit') ? $model->audit : null;
        $savedMedia = [];
        foreach ($media as $mediaData) {
            if (is_string($mediaData)) {
                $savedMedia[] = $this->uploadFile('media', $mediaData, $model, $audit, $disableAuditing);
            } elseif (is_array($mediaData) && isset($mediaData['media']) && is_string($mediaData['media'])) {
                $savedMedia[] = $this->uploadFile('media', $mediaData['media'], $model, $audit, $disableAuditing);
            }
        }

        $model->setRelation('media', collect($savedMedia));

        return $model;
    }
}
