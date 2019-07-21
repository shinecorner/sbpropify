<?php

namespace App\Models;


class PostView extends Model
{
    public $table = 'post_view';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
