<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUnitColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Unit::withTrashed()
            ->update([
                "monthly_net_rent" => DB::raw("`monthly_rent`"),
                "monthly_gross_rent" => DB::raw("`monthly_rent`"),
            ]);
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('monthly_net_rent' ,'monthly_rent_net');
            $table->renameColumn('monthly_gross_rent', 'monthly_rent_gross');
            $table->dropColumn('monthly_rent');
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
            $table->renameColumn('monthly_rent_net', 'monthly_net_rent');
            $table->renameColumn('monthly_rent_gross', 'monthly_gross_rent');
            $table->decimal('monthly_rent')->default(0.0);
        });
    }
}
