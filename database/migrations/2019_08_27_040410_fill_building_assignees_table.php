<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillBuildingAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $buildingManagers = \Illuminate\Support\Facades\DB::table('building_property_manager')->get();
        foreach ($buildingManagers as $buildingManager) {
            \App\Models\BuildingAssignee::create([
                'building_id' => $buildingManager->building_id,
                'assignee_id' => $buildingManager->property_manager_id,
                'assignee_type' => get_morph_type_of(\App\Models\PropertyManager::class),
                'created_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
