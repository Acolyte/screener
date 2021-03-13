<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;
use Throwable;

class HistoricalDataProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->providers() as $code => $config) {
            if (!is_array($config)) {
                continue;
            }
            try {
                $config['code'] = $code;
                $provider = new Provider();
                foreach ($config as $key => $value) {
                    if (!is_array($value)) {
                        $provider->setAttribute($key, $value);
                    }
                }
                $provider->saveOrFail();
            }
            catch(Throwable $ex) {
                echo 'Failed to seed ' . $config['name'] . ': ' . $ex->getMessage() . PHP_EOL;
            }
        }
    }

    public function providers()
    {
        return config('app.historicaldata');
    }
}
