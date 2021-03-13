<?php

namespace App\Console\Commands;

use App\Enum\ProviderEnum;
use App\Enum\StockEnum;
use App\Facades\HistoricalData;
use App\Models\Exchange;
use App\Models\Provider;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class PopulateStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:stocks {filename : The location of the file to be imported}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate stocks from a file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $Filename = $this->argument('filename');
        if (empty($Filename)) {
            echo 'No filename for CSV file to import has been specified' . PHP_EOL;
            return 1;
        }

        try {
            $Provider = Provider::query()->where('code', ProviderEnum::alphavantage()->label)->firstOrFail();
        }
        catch(Throwable $ex) {
            echo 'Failed to retrieve provider with code "' . ProviderEnum::alphavantage()->label . '" from the database, perform migration and seeding first' . PHP_EOL;
            return 1;
        }

        echo 'Begin processing ' . $Provider->name . ' data ...' . PHP_EOL;
        $ProviderExchanges = HistoricalData::GetExchanges();

        $Exchanges = [];
        // Extract exchanges first and then insert or update them
        foreach ($ProviderExchanges as $ExchangeCode) {
            if (!in_array($ExchangeCode, array_values($Exchanges))) {
                $Exchanges[] = $ExchangeCode;
                Exchange::updateOrCreate(['provider_id' => $Provider->id, 'code' => $ExchangeCode, 'name' => $ExchangeCode]);
            }
        }
        echo 'Successfully fetched and populated ' . iterator_count($ProviderExchanges) . ' exchange(s) into the database' . PHP_EOL;

        $ExchangeList = Exchange::query()->select(['id', 'name'])->get()->all();
        $ExchangeMap = [];
        foreach ($ExchangeList as $Exchange) {
            $ExchangeMap[$Exchange->name] = $Exchange->id;
        }

        $Stocks = HistoricalData::GetStocksList();

        foreach ($Stocks as $Result) {
            $Data = ['symbol'      => $Result['symbol'],
                     'name'        => $Result['name'],
                     'exchange_id' => $ExchangeMap[$Result['exchange']],
                     'type'        => (StockEnum::from(strtolower($Result['assetType']))->value),
                     'active'      => strtolower($Result['status']) === 'active',
                     'ipoAt'       => Carbon::parse($Result['ipoDate'])->toDate(),
                     'delistedAt'  => $Result['delistingDate'] !== "null" ? Carbon::parse($Result['delistingDate'])->toDate() : null
            ];
            Stock::updateOrCreate($Data);
        }

        echo 'Successfully fetched and populated ' . iterator_count($Stocks) . ' stock entries into the database' . PHP_EOL;
        return 0;
    }
}
