<?php

namespace App\Traits;


use App\Models\Building;

trait BuildingRelation
{
    /**
     * @return mixed
     */
    public function buildings()
    {
        return $this->morphToMany(Building::class, 'assignee', 'building_assignees', 'assignee_id', 'building_id');
    }
}
