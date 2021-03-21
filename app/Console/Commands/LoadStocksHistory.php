<?php

namespace App\Console\Commands;

use App\Enum\StockEnum;
use App\Enum\TimeframeEnum;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Console\Command;

class LoadStocksHistory extends Command
{
    public const DEFAULT_STOCK_LOAD_LIMIT = 100;
    public const DEFAULT_STOCK_TICK = TimeframeEnum::D;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stocks:load {type : Stock type} {--limit=} {--from=} {--to=} {--tick=}';

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
        $Provider = config('app.dataprovider.default');

        $Type = $this->argument('type');
        if (empty($Type)) {
            echo 'No stock type has been specified for loading (between ' . StockEnum::COMMON_STOCK . ' and ' . StockEnum::PREFERRED_STOCK . ', exiting' . PHP_EOL;
            return 1;
        }

        if (!in_array(intval($Type), [StockEnum::COMMON_STOCK, StockEnum::ETF, StockEnum::FUND, StockEnum::BOND,
                                      StockEnum::MUTUAL_FUND, StockEnum::PREFERRED_SHARE, StockEnum::PREFERRED_STOCK])) {

            echo 'Invalid stock type has been specified, valid values are ' .
                implode(', ', [StockEnum::COMMON_STOCK, StockEnum::ETF, StockEnum::FUND, StockEnum::BOND,
                               StockEnum::MUTUAL_FUND, StockEnum::PREFERRED_SHARE, StockEnum::PREFERRED_STOCK]) . PHP_EOL;
            return 1;
        } else {
            $Type = StockEnum::make(intval($Type));
        }

        $Limit = $this->option('limit');
        if (empty($Limit)) {
            $Limit = config('app.' . $Provider . '.stock_load_limit') ?
                config('app.' . $Provider . '.stock_load_limit') : self::DEFAULT_STOCK_LOAD_LIMIT;
            echo 'No limit has been specified, setting to ' . $Limit . PHP_EOL;
        } else {
            $Limit = intval($Limit);
        }

        $From = $this->option('from');
        if (empty($From)) {
            $From = Carbon::now()->subYear()->startOfYear();
            echo 'No from date has been specified, setting to ' . $From->toDateString() . PHP_EOL;
        } else {
            try {
                $From = Carbon::parse($From);
            } catch (InvalidFormatException $ex) {
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
            } catch (InvalidFormatException $ex) {
                echo 'Invalid to date format: ' . $ex->getMessage() . PHP_EOL;
            }
        }

        $Tick = $this->argument('tick');
        if (empty($Type)) {
            echo 'No stock tick has been specified for loading (between ' . TimeframeEnum::D .
                ' and ' . TimeframeEnum::Y . ', exiting' . PHP_EOL;
            return 1;
        }

        if (!in_array(intval($Tick), [TimeframeEnum::D, TimeframeEnum::W, TimeframeEnum::M, TimeframeEnum::Y])) {

            echo 'Invalid stock tick has been specified, valid values are ' .
                implode(', ', [TimeframeEnum::D, TimeframeEnum::W, TimeframeEnum::M, TimeframeEnum::Y]) . PHP_EOL;
            return 1;
        } else {
            $Tick = TimeframeEnum::make(intval($Tick));
        }

        return 0;
    }
}
