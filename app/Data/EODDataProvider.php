<?php

namespace App\Data;

use App\Enum\ProviderEnum;
use App\Models\Currency;
use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Traversable;

class EODDataProvider implements DataProvider
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return \Traversable
     */
    public function GetExchanges(): Traversable
    {
        $Filename = ProviderEnum::eod()->label . '_exchanges.bson';
        if (Storage::disk('local')->exists($Filename)) {
            return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
        } else {
            $Client = new Client();
            $URL = $this->config['urls']['exchanges'];
            foreach (['{EOD_API_KEY}' => $this->config['key']] as $Search => $Replace) {
                $URL = str_replace($Search, $Replace, $URL);
            }
            try {
                $JSON = $Client->get($URL);
                $Results = json_decode($JSON->getBody()->getContents(), false);
                $NormalizedResults = $this->ToExchanges($Results);
                Storage::disk('local')->put($Filename, igbinary_serialize($NormalizedResults));
                return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
            }
            catch(GuzzleException $ex) {
                Log::error('Failed to fetch exchanges from ' . $this->config['name'] . ' provider', ['message' => $ex->getMessage()]);
            }
            catch(Throwable $ex) {
                Log::error('Failed to save exchanges list response from ' . $this->config['name'] . ' provider to storage', ['message' => $ex->getMessage()]);
            }
        }

        return collect([]);
    }

    /**
     * Calls https://eodhistoricaldata.com/api/exchange-symbol-list/{EXCHANGE_CODE}?api_token={YOUR_API_KEY}
     * @param null $Exchange
     * @return \Traversable
     */
    public function GetStocksList($Exchange = null): Traversable
    {
        if (is_null($Exchange)) {
            Log::error('Cannot retrieve stocks without exchange with provider ' . ProviderEnum::eod()->label);
            return collect([]);
        }

        $Filename = ProviderEnum::eod()->label . '_exchange_' . $Exchange->code . '.bson';
        if (Storage::disk('local')->exists($Filename)) {
            return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
        } else {
            $Client = new Client();
            $URL = $this->config['urls']['exchanges'];
            foreach (['{EXCHANGE_CODE}' => $Exchange->code, '{EOD_API_KEY}' => $this->config['key']] as $Search => $Replace) {
                $URL = str_replace($Search, $Replace, $URL);
            }

            try {
                $JSON = $Client->get($URL);
                $Results = json_decode($JSON->getBody()->getContents(), false);
                $Exchanges = $this->ToExchanges($Results);
                Storage::disk('local')->put($Filename, igbinary_serialize($Exchanges));
                return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
            }
            catch(GuzzleException $ex) {
                Log::error('Failed to fetch stocks list from ' . $Exchange->name . ' exchange with ' . $this->config['name'] . ' provider', ['message' => $ex->getMessage()]);
            }
            catch(Throwable $ex) {
                Log::error('Failed to save stocks list response from ' . $Exchange->name . ' exchange with ' . $this->config['name'] . ' provider to storage', ['message' => $ex->getMessage()]);
            }
        }

        return collect([]);
    }

    /**
     * Calls https://eodhistoricaldata.com/api/eod-bulk-last-day/{EXCHANGE_CODE}?api_token={YOUR_API_KEY}
     *
     * @param                    $Stock
     * @param \DateTimeInterface $Date
     * @param                    $Period
     * @param                    $Filters
     * @return \Traversable
     */
    public function GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters): Traversable
    {
        return collect([]);
    }

    /**
     * @param array $Results
     * @return \Traversable
     */
    private function ToExchanges(array $Results): Traversable
    {
        $Currencies = Currency::all();
        /** @var \App\Data\Exchange[] $Response */
        $Response = [];
        foreach ($Results as $Result) {
            $Currency = $Currencies->firstWhere('code', '=', $Result->Currency);
            $Response[] = new Exchange($Result->Code, $Result->Name, null, $Currency ? $Currency->id : null, $Result->OperatingMIC);
        }

        return collect($Response);
    }
}
