<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSomePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(\App\Models\Permission::class, ['name', 'description'], 'publish', '(un)publish');
        update_db_fileds(\App\Models\Permission::class, ['display_name'], 'Publish', '(Un)Publish', false);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        update_db_fileds(\App\Models\Permission::class, ['name', 'description'], '(un)publish', 'publish');
        update_db_fileds(\App\Models\Permission::class, ['display_name'], '(Un)Publish', 'Publish', false);
    }
}
