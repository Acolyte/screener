<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;
use Throwable;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->providers() as $providerData) {
            try {
                $provider = new Provider($providerData);
                $provider->saveOrFail();
            }
            catch(Throwable $ex) {
                echo 'Failed to seed ' . $providerData['name'] . ': ' . $ex->getMessage() . PHP_EOL;
            }
        }
    }

    public function providers()
    {
        return config('app.stock');
    }
}
