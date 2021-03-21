<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Enum\TimeframeEnum;
use App\Facades\DataProvider;
use App\Models\Stock;
use DateTimeInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetStockTickers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Stock
     */
    private Stock $stock;

    /**
     * @var \DateTimeInterface
     */
    private DateTimeInterface $from;

    /**
     * @var \DateTimeInterface
     */
    private DateTimeInterface $to;

    /**
     * @var \App\Enum\TimeframeEnum
     */
    private TimeframeEnum $ticker;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Stock       $stock
     * @param \DateTimeInterface      $from
     * @param \DateTimeInterface      $to
     * @param \App\Enum\TimeframeEnum $ticker
     */
    public function __construct(Stock $stock, DateTimeInterface $from, DateTimeInterface $to, TimeframeEnum $ticker)
    {
        $this->stock = $stock;
        $this->from = $from;
        $this->to = $to;
        $this->ticker = $ticker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Stocks = DataProvider::GetStockData($this->stock, $this->from, $this->to, $this->ticker);

        /** @var \App\Data\Ticker $Result */
        foreach ($Stocks as $Result) {
            $Data = [
                'stock_id'  => $this->stock->id,
                'timeframe' => $this->ticker->toId(),
                'date'      => $Result->Date,
                'open'      => $Result->Open,
                'close'     => $Result->Close,
                'low'       => $Result->Low,
                'high'      => $Result->High,
                'volume'    => $Result->Volume,
            ];
            Stock::updateOrCreate($Data);
        }
    }
}
