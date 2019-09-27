<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixMorphTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(\App\Models\Comment::class, ['commentable_type'], 'post', 'pinboard');
        update_db_fileds(\App\Models\Conversation::class, ['conversationable_type'], 'post', 'pinboard');
        update_db_fileds(\App\Models\Like::class, ['likeable_type'], 'post', 'pinboard');
        update_db_fileds(\App\Models\Media::class, ['model_type'], 'post', 'pinboard');

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
