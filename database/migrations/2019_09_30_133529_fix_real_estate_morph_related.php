<?php

use OwenIt\Auditing\Models\Audit;
use Illuminate\Database\Migrations\Migration;

class FixRealEstateMorphRelated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(Audit::class, ['auditable_type'], 'real_estate', 'settings');
        update_db_fileds(Audit::class, ['auditable_type'], 'App\\Models\\RealEstate', 'settings');
        update_db_fileds(Audit::class, ['auditable_type'], 'App\\Models\\Tenant', 'tenant');
        update_db_fileds(Audit::class, ['auditable_type'], 'App\\Models\\Building', 'building');
        update_db_fileds(\Illuminate\Notifications\DatabaseNotification::class, ['notifiable_type'], 'App\\Models\\User', 'user');
        update_db_fileds(\Illuminate\Notifications\DatabaseNotification::class, ['notifiable_type'], "App\\Models\\User", 'user');

        \App\Models\Permission::where('name' , 'view-real_estate')->update([
            'name' => 'view-settings',
            'display_name' => 'View settings',
            'description' => 'view settings'
        ]);

        \App\Models\Permission::where('name' , 'edit-real_estate')->update([
            'name' => 'edit-settings',
            'display_name' => 'Edit settings',
            'description' => 'edit settings'
        ]);

        update_db_fileds(\App\Models\Media::class, ['disk'], 'post', 'pinboard');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        update_db_fileds(Audit::class, ['auditable_type'], 'settings', 'real_estate');

    }
}
