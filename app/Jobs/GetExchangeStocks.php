<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Facades\DataProvider;
use App\Models\Exchange;
use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetExchangeStocks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Exchange $Exchange
     */
    private Exchange $Exchange;

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

        /** @var \App\Data\Stock $Result */
        foreach ($Stocks as $Result) {
            $Data = ['code'        => $Result->Code,
                     'name'        => $Result->Name,
                     'exchange_id' => $this->Exchange->id,
                     'type'        => $Result->Type,
                     'active'      => $Result->Active,
                     'ipo_at'      => $Result->IPOAt ? $Result->IPOAt->toDate() : null,
                     'delisted_at' => $Result->DelistedAt ? $Result->DelistedAt->toDate() : null,
            ];
            Stock::updateOrCreate($Data);
        }

        Log::info('Successfully fetched and populated ' . iterator_count($Stocks)
            . ' stock entries for ' . $this->Exchange->name . ' into the database');
    }
}
