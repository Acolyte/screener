<?php

namespace App\Data;

use App\Enum\ProviderEnum;
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
        if (Storage::disk('local')->exists(ProviderEnum::eod()->label . '_exchanges.bson')) {
            return igbinary_unserialize(Storage::disk('local')->get(ProviderEnum::eod()->label . '_exchanges.bson'));
        } else {
            $Client = new Client();
            $URL = $this->config['urls']['exchanges'];
            foreach (['{EOD_API_KEY}' => $this->config['key']] as $Search => $Replace) {
                $URL = str_replace($Search, $Replace, $URL);
            }
            try {
                $JSON = $Client->get($URL);
                Storage::disk('local')->put(ProviderEnum::eod()->label . '_exchanges.bson', igbinary_serialize($JSON->getBody()->getContents()));
                return json_decode($JSON->getBody()->getContents());
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

}
