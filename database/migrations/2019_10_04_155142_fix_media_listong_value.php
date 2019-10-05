<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixMediaListongValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(\App\Models\Media::class, ['disk', 'model_type'], 'product', 'listing');
        update_db_fileds(\App\Models\Comment::class, ['commentable_type'], 'product', 'listing');
        update_db_fileds(\App\Models\Conversation::class, ['conversationable_type'], 'product', 'listing');
        update_db_fileds(\App\Models\Like::class, ['likeable_type'], 'product', 'listing');
        update_db_fileds(\App\Models\Template::class, ['name', 'subject', 'body'], 'product', 'listing', true);
        update_db_fileds(\App\Models\TemplateCategory::class, ['name', 'subject', 'body', 'description'], 'product', 'listing', true);
        $this->love_like_counters('post', 'pinboard');
        $this->love_like_counters('product', 'listing');

        update_db_fileds(\OwenIt\Auditing\Models\Audit::class, ['auditable_type', 'old_values', 'new_values'], 'product', 'listing');
        update_db_fileds(\Illuminate\Notifications\DatabaseNotification::class, ['data'], 'product', 'listing');
        update_db_fileds(\Illuminate\Notifications\DatabaseNotification::class, ['data'], 'post', 'pinboard');
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

    protected function love_like_counters($old, $new)
    {
        $items = \Illuminate\Support\Facades\DB::table('love_like_counters')->whereIn('likeable_type', [$old, $new])->get();


        foreach ($items->groupBy('likeable_id') as $groups) {
            if ($groups->count() == 1) {
                $item = $groups->first();
                if ($item->likeable_type == $new) {
                    continue;
                }
                \Illuminate\Support\Facades\DB::table('love_like_counters')->where('id', $item->id)->update(['likeable_type' => $new]);

                echo 'In filed:  likeable_type of love_like_counters: ' . $item->id .   PHP_EOL;

                echo '[' . $old  . "] replaced to [" . $new  . ']' . PHP_EOL;
            } else {
                $count = $groups->sum('count');
                $item = $groups->where('likeable_type', $new)->first();
                \Illuminate\Support\Facades\DB::table('love_like_counters')->where('id', $item->id)->update(['count' => $count]);

                foreach ( $groups->where('likeable_type', $old) as $needDeleteItem) {
                    \Illuminate\Support\Facades\DB::table('love_like_counters')->where('id', $needDeleteItem->id)->delete();
                }

            }
        }
    }
}
