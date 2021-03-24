<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Enum\StockEnum;
use App\Enum\TimeframeEnum;
use App\Jobs\GetStockTickers;
use App\Models\Stock;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class LoadStocksHistory extends Command
{
    public const STOCK_BATCH_SIZE   = 10;
    public const DEFAULT_STOCK_TICK = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stocks:load {--type=} {--batch=} {--from=} {--to=} {--tick=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load all stocks of specified type';

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
        $Type = $this->option('type');
        if (empty($Type)) {
            echo 'No stock type has been specified for loading (between ' . StockEnum::commonStock()->toName() .
                ' and ' . StockEnum::preferredStock()->toName() . ', using '
                . StockEnum::commonStock()->toName() . PHP_EOL;
            $Type = StockEnum::commonStock()->toId();
        } else {
            $Type = StockEnum::create(intval($Type));
        }

        /** offset and limit do not work with chunk
         * @see https://github.com/laravel/framework/issues/28590
         */

        /* $Limit = $this->option('limit');
         if (empty($Limit)) {
             $Limit = config('app.dataprovider.stock_load_limit') ?
                 intval(config('app.dataprovider.stock_load_limit')) : Stock::query()->count();
             echo 'No limit has been specified, setting to ' . $Limit . PHP_EOL;
         } else {
             $Limit = intval($Limit);
         }

         $Offset = $this->option('offset');
         if (empty($Offset)) {
             $Offset = 0;
             echo 'No offset has been specified, setting to ' . $Offset . PHP_EOL;
         } else {
             $Offset = intval($Offset);
         }*/

        $BatchSize = $this->option('batch');
        if (empty($BatchSize)) {
            $BatchSize = self::STOCK_BATCH_SIZE;
            echo 'No batch size has been specified, setting to ' . $BatchSize . PHP_EOL;
        } else {
            $BatchSize = intval($BatchSize);
        }

        $From = $this->option('from');
        if (empty($From)) {
            $From = Carbon::now()->subYear()->startOfYear();
            echo 'No from date has been specified, setting to ' . $From->toDateString() . PHP_EOL;
        } else {
            try {
                $From = Carbon::parse($From);
            }
            catch(InvalidFormatException $ex) {
                echo 'Invalid from date format: ' . $ex->getMessage() . PHP_EOL;
            }
        }

        $To = $this->option('to');
        if (empty($To)) {
            $To = Carbon::now();
            echo 'No to date has been specified, setting to ' . $To->toDateString() . PHP_EOL;
        } else {
            try {
                $To = Carbon::parse($To);
            }
            catch(InvalidFormatException $ex) {
                echo 'Invalid to date format: ' . $ex->getMessage() . PHP_EOL;
            }
        }

        $Tick = $this->option('tick');
        if (empty($Tick)) {
            $Tick = config('app.dataprovider.stock_tick') ?
                TimeframeEnum::create(intval(config('app.dataprovider.stock_tick'))) : self::DEFAULT_STOCK_TICK;
        } else {
            $Tick = TimeframeEnum::create(intval($Tick));
        }

        $Batches = [];

        Stock::query()->where('type', $Type)
             ->orderBy('code')->chunk($BatchSize, function (Collection $Stocks) use (&$Batches, $From, $To, $Tick)
            {
                $Batches[] = new GetStockTickers($Stocks->pluck('id')->toArray(), $From, $To, $Tick);
            });

        echo 'Dispatching work on ' . count($Batches) . ' batch(es) with ' . $BatchSize . ' stocks per batch' . PHP_EOL;

        $Batch = Bus::batch([$Batches])->then(function (Batch $batch)
        {
            Log::info('All jobs in batch ' . $batch->id . ' were completed successfully');
        })->catch(function (Batch $batch, Throwable $e)
        {
            Log::error('Error during batch ' . $batch->id . ' processing: ' . $e->getMessage());
        })->finally(function (Batch $batch)
        {

        })->dispatch();
        echo 'Successfully dispatched work to work queue with batch ID of ' . $Batch->id . PHP_EOL;
        return 0;
    }
}
