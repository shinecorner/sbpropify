<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixContsratintsInServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_providers', function (Blueprint $table) {
            $table->dropForeign('service_providers_address_id_foreign');
            $table->dropForeign('service_providers_user_id_foreign');
            $table->dropIndex('service_providers_address_id_foreign');
            $table->dropIndex('service_providers_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('loc_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_providers', function (Blueprint $table) {

            $table->dropForeign('service_providers_address_id_foreign');
            $table->dropForeign('service_providers_user_id_foreign');
            $table->dropIndex('service_providers_address_id_foreign');
            $table->dropIndex('service_providers_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('address_id')->references('id')->on('loc_addresses');
        });
    }
}
