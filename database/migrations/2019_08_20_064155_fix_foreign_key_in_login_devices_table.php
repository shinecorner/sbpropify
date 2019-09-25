<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixForeignKeyInLoginDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_devices', function (Blueprint $table) {
            $table->dropForeign('login_devices_tenant_id_foreign');
            $table->dropForeign('login_devices_user_id_foreign');
            $table->dropIndex('login_devices_tenant_id_foreign');
            $table->dropIndex('login_devices_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_devices', function (Blueprint $table) {
            $table->dropForeign('login_devices_tenant_id_foreign');
            $table->dropForeign('login_devices_user_id_foreign');
            $table->dropIndex('login_devices_tenant_id_foreign');
            $table->dropIndex('login_devices_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }
}
