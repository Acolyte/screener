<?php

namespace App\Jobs;

use App\Facades\DataProvider;
use App\Models\Exchange;
use App\Models\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetExchanges implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Provider $DataProvider
     */
    private $DataProvider;

    /**
     * Create a new job instance.
     *
     * @param null|\App\Models\Provider $DataProvider
     */
    public function __construct($DataProvider = null)
    {
        $this->DataProvider = $DataProvider;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->DataProvider === null) {
            $SelectedDataProvider = config('app.dataprovider.default');
            try {
                /** @var Provider $Provider */
                $this->DataProvider = Provider::query()->where('code', $SelectedDataProvider)->firstOrFail();
            }
            catch(Throwable $ex) {
                Log::error("Failed to retrieve provider with code $SelectedDataProvider from the database, perform migration and seeding first");
                $this->fail($ex);
            }
        }

        Log::info('Begin processing ' . $this->DataProvider->name . ' data');
        $ProviderExchanges = DataProvider::GetExchanges();

        foreach ($ProviderExchanges as $Exchange) {
            Exchange::updateOrCreate(['provider_id' => $this->DataProvider->id,
                                      'country_id'  => $Exchange->CountryID,
                                      'currency_id' => $Exchange->CurrencyID,
                                      'code'        => $Exchange->Code,
                                      'name'        => $Exchange->Name,
                                      'mics'        => $Exchange->MICs]);
        }

        session()->flash('message', iterator_count($ProviderExchanges) . ' exchanges successfully loaded.');
    }
}
