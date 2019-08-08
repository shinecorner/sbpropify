<?php

namespace App\Models;

use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Facades\Auditor;

class AuditableModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

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
