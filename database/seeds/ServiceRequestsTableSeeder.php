<?php

use App\Models\ServiceProvider;
use App\Models\Request;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ServiceRequestsTableSeeder extends Seeder
{
    use  \Traits\TimeTrait;
    var $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        if (App::environment('local')) {
            $admins = User::whereHas('roles', function ($query) {
                $query->where('name', 'administrator');
            })->get();

            $requests = [];
            for ($i = 0; $i < 500; $i++) {
                $date = $this->getRandomTime();
                $requests[] = factory(App\Models\Request::class)->create($this->getDateColumns($date));
            }

            $user = App\Models\User::where('email', 'tenant@example.com')->first();
            foreach ($requests as $key => $request) {
                $this->addRequestComments($request);
                if ($key < 3) {
                    continue;
                }

                $request->tenant_id = $user->tenant->id;
                $request->unit_id = $user->tenant->unit_id;
                $request->status = array_rand(Request::Status);
                $request->save();
                $providers = ServiceProvider::inRandomOrder()->take(2)->get();
                foreach ($providers as $p) {
                    $request->providers()->sync([$p->id => ['created_at' => now()]]);
                }

                $managers = \App\Models\PropertyManager::inRandomOrder()->take(2)->get();
                foreach ($managers as $m) {
                    $request->managers()->sync([$m->id => ['created_at' => now()]]);
                }
                foreach ($providers as $prov) {
                    foreach ($admins as $admin) {
                        $c = $request->conversationFor($admin, $prov->user);
                        $c->commentAsUser($admin, "Knock Knock!");
                        usleep(1000);
                        $c->commentAsUser($prov->user, "Who's there?");
                    }
                }
            }
        }
    }

    private function addRequestComments(Request $request)
    {
        $totalComments = $this->faker->numberBetween(1, 2);
        $users = [
            $request->tenant->user,
        ];

        if ($request->agent) {
            $users [] = $request->agent;
        }

        for ($i = 0; $i < $totalComments; $i++) {
            $user = $users[rand(0, count($users) - 1)];
            $request->commentAsUser($user, $this->faker->sentence(3), null);
        }

        DB::statement("UPDATE comments SET created_at = NOW() + INTERVAL -1 week + INTERVAL id second, updated_at = NOW() + INTERVAL -1 week + INTERVAL id second;");
    }
}
