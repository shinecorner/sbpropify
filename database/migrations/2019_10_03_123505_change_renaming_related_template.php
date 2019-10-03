<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRenamingRelatedTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(\App\Models\TemplateCategory::class, ['name', 'description', 'tag_map', 'subject', 'body'], 'product', 'listing');
        update_db_fileds(\App\Models\Template::class, ['name', 'subject', 'body'], 'product', 'listing');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
