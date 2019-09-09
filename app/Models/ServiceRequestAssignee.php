<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

/**
 * @SWG\Definition(
 *      definition="ServiceRequestAssignee",
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="item_id",
 *          description="related assigner id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="edit_id",
 *          description="@TODO must be delete",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="related assigner type",
 *          type="string",
 *          format="int32",
 *          enum={"user", "provider", "manager"}
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="emai;",
 *          type="string"
 *      ),
 * )
 */
class ServiceRequestAssignee extends AuditableModel
{
    protected $table = 'request_assignees';

    public $timestamps = false;

    public $fillable = [
        'request_id',
        'assignee_id',
        'assignee_type',
        'created_at',
    ];

    public $auditEvents = [
        AuditableModel::EventDeleted
    ];

    /**
     * {@inheritdoc}
     */
    public function transformAudit(array $data): array
    {
        if (AuditableModel::EventDeleted != $data['event']) {
            return $data;
        }
        $data['auditable_id'] = $this->request_id;
        $data['auditable_type'] = get_morph_type_of(\App\Models\ServiceRequest::class);

        [$event, $olddata] = $this->getAuditData();
        $data['old_values'] = $olddata;
        $data['event'] = $event;
        return $data;
    }

    // @TODO make more good way
    protected function getAuditData()
    {
        $model = Relation::$morphMap[$this->assignee_type] ?? $this->assignee_type;
        $config = [
            User::class => ['name'],
            ServiceProvider::class => ['name'],
            PropertyManager::class => ['first_name', 'last_name'],
        ];
        if (! class_exists($model)) {
            return [];
        }
        $eventConvig = [
            User::class => AuditableModel::EventUserUnassigned,
            ServiceProvider::class => AuditableModel::EventProviderUnassigned,
            PropertyManager::class => AuditableModel::EventManagerUnassigned,
        ];

        $instance = new $model();
        $columns = array_merge([$instance->getKeyName()], $config[$model] ?? []);
        try {
            $instance = $instance->where($instance->getKeyName(), $this->assignee_id)->withTrashed()->first($columns);
        } catch (\Exception $e) {
            $instance = $instance->where($instance->getKeyName(), $this->assignee_id)->first($columns);
        }
        if (empty($instance)) {
            return [$eventConvig[$model] ?? 'deleted', []];
        }

        $attributes = $instance->getAttributes();
        $prefix = Str::singular($instance->getTable()) . '_';

        $oldData = [];
        foreach ($attributes as $attribute => $value) {
            $oldData[$prefix . $attribute] = $value;
        }

        return [$eventConvig[$model] ?? 'deleted', $oldData];
    }
}
