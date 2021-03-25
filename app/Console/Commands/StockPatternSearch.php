<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Core\Search;
use App\Enum\AnalysisEnum;
use App\Enum\TimeframeEnum;
use App\Models\Stock;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Console\Command;

class StockPatternSearch extends Command
{
    public const DEFAULT_STOCK_TICK = 1;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:search {--codes=} {--from=} {--to=} {--tick=}, {--analysis=}';

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
        $Codes = $this->option('codes');
        if (empty($Codes)) {
            echo 'No stock code(s) were been given, processing all' . PHP_EOL;
            $Stocks = Stock::all();
        } else {
            $Stocks = Stock::query()->whereIn('code', explode(',', $Codes))->get();
        }

        $Analysis = $this->option('analysis');
        if (empty($Analysis)) {
            echo 'No analysis has been specified for performing on stock, using '
                . AnalysisEnum::hl()->toName() . PHP_EOL;
            $Analysis = AnalysisEnum::hl();
        } else {
            $Analysis = AnalysisEnum::create(intval($Analysis));
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

        foreach ($Stocks as $Stock) {
            $Search = new Search($Stock, $From, $To, $Tick, $Analysis);
            $Result = $Search->Search();
            echo 'Data for stock ' . $Stock->code . ' is: ' . $Result . PHP_EOL;
        }
        return 0;
    }
}
