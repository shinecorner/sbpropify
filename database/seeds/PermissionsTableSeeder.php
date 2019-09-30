<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('permissions.all') as $p) {
            (new Permission([
                'name' => $p[0],
                'display_name' => $p[1],
                'description' => $p[2],
            ]))->save();
        }
    }
}
