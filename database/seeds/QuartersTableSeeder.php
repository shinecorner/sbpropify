<?php

use Illuminate\Database\Seeder;

class QuartersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!App::environment('local')) {
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            $quarter = factory(App\Models\Quarter::class)->create([
                'name' => 'Quarter ' . $i,
            ]);
            $users = \App\Models\User::withRole('administrator')->inRandomOrder()->limit(random_int(1,5))->get();
            $data = [];
            foreach ($users as $user) {
                $data[$user->id] = ['created_at' => now(),];
            }
            $quarter->users()->attach($data);
        }
    }
}
