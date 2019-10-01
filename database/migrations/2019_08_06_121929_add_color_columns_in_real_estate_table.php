<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorColumnsInRealEstateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->string('primary_color', 60)->after('logo')->nullable();
            $table->string('accent_color', 60)->after('logo')->nullable();
        });
        \App\Models\Settings::where('id', '!=', 0)->update([
            'primary_color' => '#6AC06F',
            'accent_color' => '#F7CA18'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropColumn('primary_color', 'accent_color');
        });
    }
}
