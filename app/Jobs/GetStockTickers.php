<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Enum\TimeframeEnum;
use App\Facades\DataProvider;
use App\Models\Tick;
use DateTimeInterface;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetStockTickers implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Stock[]
     */
    private array $stocks;

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
     * @param \App\Models\Stock[]     $stocks
     * @param \DateTimeInterface      $from
     * @param \DateTimeInterface      $to
     * @param \App\Enum\TimeframeEnum $ticker
     */
    public function __construct(array $stocks, DateTimeInterface $from, DateTimeInterface $to, TimeframeEnum $ticker)
    {
        $this->stocks = $stocks;
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
        foreach ($this->stocks as $stock) {
            if ($this->batch()->cancelled()) {
                return;
            }

            $StockTicks = DataProvider::GetStockData($stock, $this->from, $this->to, $this->ticker);

            /** @var \App\Data\Ticker $Result */
            foreach ($StockTicks as $Result) {
                $Data = [
                    'stock_id'  => $stock->id,
                    'timeframe' => $this->ticker->toId(),
                    'date'      => $Result->Date,
                    'open'      => $Result->Open,
                    'close'     => $Result->Close,
                    'low'       => $Result->Low,
                    'high'      => $Result->High,
                    'volume'    => $Result->Volume,
                ];
                try {
                    Tick::updateOrCreate($Data);
                }
                catch(Throwable $ex) {
                    Log::error('Failed to save tick data for stock ' . $stock->code . ': ' . $ex->getMessage());
                    if (App::runningInConsole()) {
                        echo 'Failed to save tick data for stock ' . $stock->code . ': ' . $ex->getMessage() . PHP_EOL;
                    }
                }
            }

            Log::info('Stock ' . $stock->code . ' with ' . iterator_count($StockTicks) . ' tick(s) has been loaded successfully');
            if (App::runningInConsole()) {
                echo 'Stock ' . $stock->code . ' with ' . iterator_count($StockTicks) . ' tick(s) has been loaded successfully' . PHP_EOL;
            }
        }
    }
}
