<?php

namespace App\Models;

use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Facades\Auditor;

class AuditableModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const EventCreated = 'created';
    const EventUpdated = 'updated';
    const EventDeleted = 'deleted';
    const EventUserAssigned = 'user_assigned';
    const EventUserUnassigned = 'user_unassigned';
    const EventProviderAssigned = 'provider_assigned';
    const EventProviderUnassigned = 'provider_unassigned';
    const EventProviderNotified = 'provider_notified';
    const EventMediaUploaded = 'media_uploaded';
    const EventMediaDeleted = 'media_deleted';

    const Events = [
        self::EventCreated,
        self::EventUpdated,
        self::EventDeleted,
        self::EventProviderAssigned,
        self::EventProviderUnassigned,
        self::EventProviderNotified,
        self::EventUserAssigned,
        self::EventUserUnassigned,
        self::EventMediaUploaded,
        self::EventMediaDeleted,
    ];

    protected $auditData;

    /**
     * @param $event
     * @param array $auditData
     */
    public function registerAuditEvent($event, $auditData = [])
    {
        Auditor::execute($this->setAuditEvent($event));
        $this->setAuditData($auditData);

    }

    /**
     * @param $auditData
     * @return $this
     */
    public function setAuditData($auditData)
    {
        $this->$auditData = $auditData;
        return $this;
    }

    /**
     * @param $relation
     * @param $parent
     * @param $ids
     * @param $auditType
     */
    protected static function auditManyRelations($relation, $parent, $ids, $auditType)
    {
        if (empty($auditType)) {
            return;
        }

        $model = $parent->{$relation}()->getRelated();
        $relationAuditColumns = $parent->syncAuditable[$relation] ?? [];
        $columns = array_merge([$model->getKeyName()], $relationAuditColumns);
        $models = $model->whereIn($model->getKeyName(), $ids)->get($columns);
        foreach ($models as $model) {
            $parent->sync_model = $model;
            Auditor::execute($parent->setAuditEvent($auditType));
        }
    }

    /**
     * @param $model
     * @return array
     */
    protected function getRelationAudits($model)
    {
        $syncModel = $model->sync_model;
        $attributes = $syncModel->getAttributes();
        $prefix = Str::singular($syncModel->getTable()) . '_';
        $data = [];
        foreach ($attributes as $attribute => $value) {
            $data[$prefix . $attribute] = $value;
        }
        return $data;
    }

    /**
     * @param string $syncAction
     * @return array
     */
    protected function getSyncEventAttributes($syncAction = 'attach')
    {
        if ('attach' == $syncAction) {
            return [
                [],
                $this->getRelationAudits($this)
            ];
        }

        return [
            $this->getRelationAudits($this),
            [],
        ];
    }
}
