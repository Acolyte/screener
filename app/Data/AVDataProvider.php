<?php

namespace App\Data;

use App\Enum\ProviderEnum;
use App\Util\Util;
use DateTimeInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Traversable;

class AVDataProvider implements DataProvider
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function GetExchanges(): Traversable
    {
        $Filename = ProviderEnum::alphavantage()->label . '_exchanges.bson';
        if (Storage::disk('local')->exists($Filename)) {
            return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
        } else {
            $Client = new Client();
            $URL = $this->config['urls']['exchanges'];
            foreach (['{AV_API_KEY}' => $this->config['key']] as $Search => $Replace) {
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
                Log::error('Failed to fetch exchanges from ' . $this->config['name'] . ' provider', ['message' => $ex->getMessage()]);
            }
            catch(Throwable $ex) {
                Log::error('Failed to save exchanges list response from ' . $this->config['name'] . ' provider to storage', ['message' => $ex->getMessage()]);
            }
        }

        return collect([]);
    }

    public function GetStocksList($Exchange = null): Traversable
    {
        return collect([]);
    }

    public function GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters): Traversable
    {
        return collect([]);
    }

    private function GetExchangesFromListings(): iterable
    {
        $Results = Util::ArrayFromCSV(Storage::disk('local')->path(ProviderEnum::alphavantage()->label . '_listings.csv'), true);
        if (!$Results) {
            Log::error('Failed to parse stock listings response from  ' . $this->config['name'] . 'provider');
            return collect([]);
        }

        $Exchanges = [];
        // Extract exchanges first and then insert or update them
        foreach ($Results as $Result) {
            if (!in_array($Result['exchange'], array_values($Exchanges))) {
                $Exchanges[] = $Result['exchange'];
            }
        }
        return collect($Exchanges);
    }

    /**
     * @param array $Results
     * @return \Traversable
     */
    private function ToExchanges(array $Results): Traversable
    {
        throw new Exception("Not implemented");
    }
}
