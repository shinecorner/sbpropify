<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixPinboardTemplates2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(\App\Models\TemplateCategory::class, ['name', 'description', 'tag_map', 'subject', 'body'], 'post', 'pinboard');
        update_db_fileds(\App\Models\Template::class, ['name', 'subject', 'body'], 'post', 'pinboard');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        update_db_fileds(\App\Models\TemplateCategory::class, ['name', 'description', 'tag_map', 'subject', 'body'], 'pinboard', 'post');
        update_db_fileds(\App\Models\Template::class, ['name', 'subject', 'body'], 'pinboard', 'post');
    }
}
