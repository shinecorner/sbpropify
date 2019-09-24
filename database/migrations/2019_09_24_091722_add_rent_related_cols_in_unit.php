<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRentRelatedColsInUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->decimal('net_rent')->nullable()->default(0.0)->after('monthly_rent');
            $table->decimal('gross_rent')->nullable()->default(0.0)->after('net_rent');
            $table->integer('maintenance')->nullable()->default(0.0)->after('gross_rent');
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
            $table->dropColumn('net_rent', 'gross_rent', 'maintenance');
        });
    }
}
