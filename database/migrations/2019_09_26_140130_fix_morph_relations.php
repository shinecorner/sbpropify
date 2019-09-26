<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixMorphRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(\OwenIt\Auditing\Models\Audit::class, ['auditable_type', 'old_values', 'new_values', 'url'], 'post', 'pinboard');
        update_db_fileds(\App\Models\TemplateCategory::class, ['tag_map'], 'post', 'pinboard');
        update_db_fileds(\App\Models\Permission::class, ['name', 'display_name', 'description'], 'post', 'pinboard');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        update_db_fileds(\OwenIt\Auditing\Models\Audit::class, ['auditable_type', 'old_values', 'new_values', 'url'], 'pinboard', 'post');
        update_db_fileds(\App\Models\TemplateCategory::class, ['tag_map'], 'pinboard', 'post');
        update_db_fileds(\App\Models\Permission::class, ['name', 'display_name', 'description'], 'pinboard', 'post');
    }
}
