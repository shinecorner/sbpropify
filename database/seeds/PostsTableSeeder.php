<?php

use App\Models\Pinboard;
use App\Repositories\PinboardRepository;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $pRepo = new PostRepository(app());
        if (App::environment('local')) {
            $totalPosts = 200;
            $posts = factory(App\Models\Pinboard::class, $totalPosts)->create(['status' => Pinboard::StatusPublished]);
            foreach ($posts as $post) {
                $u = $post->user;
                if ($u->tenant && $u->tenant->building) {
                    $post->buildings()->sync($u->tenant->building->id);
                    if ($u->tenant->building->quarter_id) {
                        $post->quarters()->sync($u->tenant->building->quarter_id);
                    }
                }
                //$pRepo->setStatus($post->id, Post::StatusPublished, now());
            }
        }
    }
}
