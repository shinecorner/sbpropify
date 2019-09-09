<?php

namespace App\Traits;

use Illuminate\Support\Str;
use OwenIt\Auditing\Facades\Auditor;

trait Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $auditData;

    /**
     * @param $event
     * @param array $auditData
     */
    public function registerAuditEvent($event, $auditData = [])
    {
        $this->setAuditData($auditData);
        Auditor::execute($this->setAuditEvent($event));
    }

    /**
     * @param $auditData
     * @return $this
     */
    public function setAuditData($auditData)
    {
        $this->auditData = $auditData;
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
        unset($model->sync_model);
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

    /**
     * @return array
     */
    public function getDetachedEventAttributes(): array
    {
        return $this->getSyncEventAttributes('detach');
    }

    /**
     * @return array
     */
    public function getAttachedEventAttributes(): array
    {
        return $this->getSyncEventAttributes('attach');
    }
}
