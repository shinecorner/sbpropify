<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillRealTenantNumColumnInTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("SET @r=0");
        $query = 'UPDATE `tenants` SET `real_tenant_num` = @r:= (@r+1)';
        \Illuminate\Support\Facades\DB::statement($query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $query = 'UPDATE `tenants` SET `real_tenant_num` = NULL';
        \Illuminate\Support\Facades\DB::statement($query);
    }
}
