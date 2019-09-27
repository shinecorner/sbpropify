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
            $pinboards = factory(App\Models\Pinboard::class, $totalPosts)->create(['status' => Pinboard::StatusPublished]);
            foreach ($pinboards as $pinboard) {
                $u = $pinboard->user;
                if ($u->tenant && $u->tenant->building) {
                    $pinboard->buildings()->sync($u->tenant->building->id);
                    if ($u->tenant->building->quarter_id) {
                        $pinboard->quarters()->sync($u->tenant->building->quarter_id);
                    }
                }
                //$pRepo->setStatus($pinboard->id, Post::StatusPublished, now());
            }
        }
    }
}
