<?php

namespace App\Jobs;

use App\Models\Exchange;
use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class PopulateStocks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StockServiceProvider $provider)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Filename = $this->argument('filename');
        if (empty($Filename)) {
            echo 'No filename for CSV file to import has been specified' . PHP_EOL;
            return 1;
        }

        $Results = $this->ArrayFromCSV($Filename, true);
        if (!$Results) {
            echo 'Could not read data from given file' . PHP_EOL;
            return 1;
        }

        $Exchanges = [];
        // Extract exchanges first and then insert or update them
        foreach ($Results as $Result) {
            if (!in_array($Result['exchange'], array_values($Exchanges))) {
                $Exchanges[] = $Result['exchange'];
                Exchange::updateOrCreate(['name' => $Result['exchange']]);
            }
        }

        $ExchangeList = Exchange::query()->select(['id', 'name'])->get()->all();
        $ExchangeMap = [];
        foreach ($ExchangeList as $Exchange) {
            $ExchangeMap[$Exchange->name] = $Exchange->id;
        }

        foreach ($Results as $Result) {
            $Data = ['symbol'      => $Result['symbol'],
                     'name'        => $Result['name'],
                     'exchange_id' => $ExchangeMap[$Result['exchange']],
                     'type'        => array_flip(Stock::$Types)[strtolower($Result['assetType'])],
                     'active'      => strtolower($Result['status']) === 'active',
                     'ipoAt'       => Carbon::parse($Result['ipoDate'])->toDate(),
                     'delistedAt'  => $Result['delistingDate'] !== "null" ? Carbon::parse($Result['delistingDate'])->toDate() : null
            ];
            Stock::updateOrCreate($Data);
        }

        echo 'Successfully processed ' . count($Results) . ' stock entries' . PHP_EOL;
        return 0;
    }
}
