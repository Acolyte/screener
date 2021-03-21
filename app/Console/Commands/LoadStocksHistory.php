<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Enum\StockEnum;
use App\Enum\TimeframeEnum;
use App\Jobs\GetStockTickers;
use App\Models\Stock;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Console\Command;

class LoadStocksHistory extends Command
{
    public const DEFAULT_STOCK_LOAD_LIMIT = 100;
    public const DEFAULT_STOCK_TICK       = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stocks:load {--type=} {--limit=} {--from=} {--to=} {--tick=}';

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

        $Type = $this->option('type');
        if (empty($Type)) {
            echo 'No stock type has been specified for loading (between ' . StockEnum::commonStock()->toName() .
                ' and ' . StockEnum::preferredStock()->toName() . ', using '
                . StockEnum::commonStock()->toName() . PHP_EOL;
            $Type = StockEnum::commonStock()->toId();
        } else {
            $Type = StockEnum::create(intval($Type));
        }

        $Limit = $this->option('limit');
        if (empty($Limit)) {
            $Limit = config('app.dataprovider.stock_load_limit') ?
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

        $Tick = $this->argument('tick');
        if (empty($Tick)) {
            $Tick = config('app.dataprovider.stock_tick') ?
                config('app.dataprovider.stock_tick') : self::DEFAULT_STOCK_TICK;
        } else {
            $Tick = TimeframeEnum::create(intval($Tick));
        }

        $Stocks = Stock::query()->where('type', $Type)->limit($Limit)->get();
        foreach ($Stocks as $Stock) {
            dispatch(new GetStockTickers($Stock, $From, $To, $Tick));
        }

        echo 'Created ' . count($Stocks) . ' job(s) to fetch historical data from ' . $From->toDateString() .
            ' to ' . $To->toDateString() . ' on ' . $Tick->toName() . ' timeframe' . PHP_EOL;
        return 0;
    }
}
