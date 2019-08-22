<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Facades\Auditor;
use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends SpatieMedia implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    /**
     * @var array
     */
    protected $auditEvents = [
        AuditableModel::EventMediaUploaded,
        AuditableModel::EventMediaDeleted,
    ];

    /**
     * @var array
     */
    protected $auditInclude = [
        'collection_name',
        'name',
        'file_name',
        'mime_type',
        'disk',
        'size',
        'order_column',
    ];

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            Auditor::execute($model->setAuditEvent(AuditableModel::EventMediaUploaded));
        });

        static::deleted(function ($model) {
            Auditor::execute($model->setAuditEvent(AuditableModel::EventMediaDeleted));
        });
    }

    /**
     * @return array
     */
    public function getMedia_uploadedEventAttributes()
    {
        $values = $this->getCreatedEventAttributes();
        $values[1]['media_id'] = $this->id;
        $values[1]['media_url'] = $this->getFullUrl();
        return $values ;
    }

    /**
     * @return array
     */
    public function getMedia_deletedEventAttributes()
    {
        $values = $this->getDeletedEventAttributes();
        $values[0]['media_id'] = $this->id;
        $values[0]['media_url'] = $this->getFullUrl();
        return $values ;
    }

    /**
     * @param array $data
     * @return array
     */
    public function transformAudit(array $data): array
    {
        $data['auditable_id'] = $this->model_id;
        $data['auditable_type'] = $this->model_type;
        return $data;
    }
}
