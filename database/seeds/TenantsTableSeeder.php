<?php

use App\Models\Building;
use App\Models\Role;
use App\Models\ServiceProvider;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserSettings;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
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

        $totalTenants = 200;
        $faker = Faker::create();
        $units = Unit::inRandomOrder()->with('building')->limit($totalTenants)->get();

        for($i = 0; $i < $totalTenants; $i++) {

            $email = $faker->safeEmail;
            if ($i == 0) {
                $email = 'tenant@example.com';
            }

            $data = factory(App\Models\Tenant::class)->make()->toArray();
            $date = $this->getRandomTime();
            $userData = [
                'name' =>  sprintf('%s %s', $data['first_name'], $data['last_name']),
                'password' => bcrypt($email),
                'email' => $email,
                'phone' => $data['mobile_phone'],
            ];
            $userData = array_merge($userData, $this->getDateColumns($date));

            $registeredRole = Role::where('name', 'registered')->first();
            $user = factory(User::class)->create($userData);
            $user->attachRole($registeredRole);
            $settings = $this->getSettings();
            $user->settings()->save($settings->replicate());


            $data['user_id'] = $user->id;
            $data['title'] = $user->title;

            if ($email == 'tenant@example.com' || rand(0, 1)) {
                $unit = $units->random();
                $building = $unit->building;
                $data['address_id'] = $building->address_id;
                $data['building_id'] = $building->id;
                $data['unit_id'] = $unit->id;
                $data['status'] = Tenant::StatusActive;

                if ($email == 'tenant@example.com') {
//                    $services = ServiceProvider::select('id')->limit(4)->inRandomOrder()->get();
//                    $building->serviceProviders()->attach($services);
                }
            }

            $data = array_merge($data, $this->getDateColumns($date));
            $tenant = factory(App\Models\Tenant::class)->create($data);
            $tenant->setCredentialsPDF($user->email);
        }
    }

    private function getSettings()
    {
        $settings = new UserSettings();
        $settings->language = 'en';
        $settings->summary = 'daily';
        $settings->admin_notification = 1;
        $settings->news_notification = 1;
        $settings->marketplace_notification = 1;
        $settings->service_notification = 1;

        return $settings;
    }
}
