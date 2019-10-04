<?php

use App\Repositories\ListingRepository;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$listingRepository = new ListingRepository(app());
        if (App::environment('local')) {
            $listings = factory(App\Models\Listing::class, 200)->create();
//            foreach ($listings as $listing) {
//                $listingRepository->notify($listing);
//            }
        }
    }
}
