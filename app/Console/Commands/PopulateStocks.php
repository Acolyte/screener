<?php

namespace App\Console\Commands;

use App\Models\Exchange;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        $Results = $this->ArrayFromCSV($Filename, true);
        if (!$Results) {
            echo 'Could not read data from given file' . PHP_EOL;
            return 1;
        }

        $Exchanges = [];
        // Extract exchanges first and populate them
        foreach ($Results as $Result) {
            if (!in_array($Result['exchange'], array_values($Exchanges))) {
                $Exchanges[] = $Result['exchange'];
                Exchange::updateOrCreate(['name' => $Result['exchange']]);
            }
        }

        $ExchangeList = Exchange::query()->select(['id', 'name'])->get()->all();
        foreach($ExchangeList as $Exchange) {
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

    private function ArrayFromCSV(string $file, bool $hasFieldNames = false, ?int $lineLength = 512, string $separator = ',', string $enclosure = '"', string $escape = "\\")
    {
        $result = [];
        $file = fopen($file, 'r');
        #TO DO: There must be a better way of finding out the size of the longest row... until then
        if ($hasFieldNames) {
            $keys = fgetcsv($file, $lineLength, $separator, $enclosure, $escape);
        }
        while ($row = fgetcsv($file, $lineLength, $separator, $enclosure, $escape)) {
            $n = count($row);
            $res = [];
            for ($i = 0; $i < $n; $i++) {
                $idx = ($hasFieldNames) ? $keys[$i] : $i;
                $res[$idx] = $row[$i];
            }
            $result[] = $res;
        }
        fclose($file);
        return $result;
    }
}
