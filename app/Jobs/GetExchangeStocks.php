<?php

namespace App\Jobs;

use App\Enum\StockEnum;
use App\Facades\DataProvider;
use App\Models\Exchange;
use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class GetExchangeStocks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Exchange $Exchange
     */
    private $Exchange;

    /**
     * Create a new job instance.
     *
     * @param Exchange $Exchange
     */
    public function __construct(Exchange $Exchange)
    {
        $this->Exchange = $Exchange;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Stocks = DataProvider::GetStocksList($this->Exchange);

        foreach ($Stocks as $Result) {
            $Data = ['symbol'      => $Result['symbol'],
                     'name'        => $Result['name'],
                     'exchange_id' => $this->Exchange->id,
                     'type'        => (StockEnum::from(strtolower($Result['assetType']))->value),
                     'active'      => strtolower($Result['status']) === 'active',
                     'ipoAt'       => Carbon::parse($Result['ipoDate'])->toDate(),
                     'delistedAt'  => $Result['delistingDate'] !== "null" ? Carbon::parse($Result['delistingDate'])->toDate() : null
            ];
            Stock::updateOrCreate($Data);
        }

        Log::info('Successfully fetched and populated ' . iterator_count($Stocks)
            . ' stock entries for ' . $this->Exchange->name . ' into the database');
    }
}
