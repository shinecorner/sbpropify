<?php

use App\Models\Address;
use App\Models\Building;
use App\Models\Quarter;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    use \Traits\TimeTrait;

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

        $faker = Faker::create();
        for($i = 1; $i <= 100; $i++) {
            $date = $this->getRandomTime();
            $hasQuarter = $faker->boolean;

            $data = $this->getDateColumns($date);
            if ($hasQuarter) {
                $data['quarter_id'] = Quarter::inRandomOrder()->first()->id;
            }

            $address = factory(Address::class)->create($this->getDateColumns($date));
            $data['address_id'] = $address->id;
            $data['name'] = sprintf('%s %s', $address->street, $address->street_nr);
            $geoData = $this->getGeoDataByAddress($address);
            $data = array_merge($data, $geoData);
            factory(Building::class)->create($data);
        }
    }

    /**
     * @param $address
     * @return array
     */
    protected function getGeoDataByAddress($address)
    {
        // @TODO remove when have correct geoapi key
        return [
            'longitude' => 0,
            'latitude' => 0
        ];
        $_address = sprintf('%s %s, %s %s', $address->street, $address->street_nr, $address->zip, $address->city);
        $client = new \GuzzleHttp\Client();
        $geocoder = new \Spatie\Geocoder\Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));

        try {
            $response = $geocoder->getCoordinatesForAddress($_address);
        } catch (\Exception $exception) {
            $response = [
                'lat' => 0,
                'lng' => 0,
            ];
        }

        return [
            'longitude' => $response['lng'],
            'latitude' => $response['lat']
        ];
    }
}
