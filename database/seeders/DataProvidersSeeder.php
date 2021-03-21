<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Enum\ProviderEnum;
use App\Models\Provider;
use Illuminate\Database\Seeder;
use Throwable;

class DataProvidersSeeder extends Seeder
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
                $provider->type = ProviderEnum::from('code', $code)->toId();
                $provider->saveOrFail();
            }
            catch(Throwable $ex) {
                echo 'Failed to seed ' . $config['name'] . ': ' . $ex->getMessage() . PHP_EOL;
            }
        }
    }

    public function providers()
    {
        return config('app.dataprovider');
    }
}
