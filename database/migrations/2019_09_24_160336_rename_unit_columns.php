<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUnitColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('net_rent', 'monthly_net_rent');
            $table->renameColumn('gross_rent', 'monthly_gross_rent');
            $table->renameColumn('maintenance', 'monthly_maintenance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('monthly_net_rent' ,'net_rent');
            $table->renameColumn('monthly_gross_rent', 'gross_rent');
            $table->renameColumn('monthly_maintenance', 'maintenance');
        });
    }
}
