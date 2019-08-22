<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillRequestAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $requestProviders = \Illuminate\Support\Facades\DB::table('request_provider')->get();
        foreach ($requestProviders as $requestProvider) {
            \App\Models\ServiceRequestAssignee::create([
                'request_id' => $requestProvider->request_id,
                'assignee_id' => $requestProvider->provider_id,
                'assignee_type' => array_flip(\Illuminate\Database\Eloquent\Relations\Relation::$morphMap)[\App\Models\ServiceProvider::class] ?? 'provider',
                'created_at' => now()
            ]);
        }
        $requestAssigners = \Illuminate\Support\Facades\DB::table('request_assignee')->get();
        $users = \App\Models\User::whereIn('id', $requestAssigners->pluck('user_id'))->with('propertyManager')->get()->keyBy('id');

        foreach ($requestAssigners as $requestAssigner) {
            $user = $users[$requestAssigner->user_id] ?? null;

            if (empty($user) || empty($user->propertyManager)) {
                \Illuminate\Support\Facades\DB::table('request_assignee')->where([
                    'request_id' => $requestAssigner->request_id,
                    'user_id' => $requestAssigner->user_id,
                ])->delete();
                continue;
            }

            \App\Models\ServiceRequestAssignee::create([
                'request_id' => $requestAssigner->request_id,
                'assignee_id' => $user->propertyManager->id,
                'assignee_type' => array_flip(\Illuminate\Database\Eloquent\Relations\Relation::$morphMap)[\App\Models\PropertyManager::class] ?? 'manager',
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
