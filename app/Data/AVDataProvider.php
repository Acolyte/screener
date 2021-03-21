<?php
declare(strict_types=1);

namespace App\Data;

use App\Enum\ProviderEnum;
use App\Enum\TimeframeEnum;
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
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function GetExchanges(): Traversable
    {
        $Filename = ProviderEnum::alphavantage()->toName() . '_exchanges.bson';
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
                if ($JSON->getStatusCode() === 200) {
                    $Results = json_decode($JSON->getBody()->getContents(), false);
                    $Exchanges = $this->ToExchanges($Results);
                    Storage::disk('local')->put($Filename, igbinary_serialize($Exchanges));
                    return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
                } else {
                    Log::error($JSON->getBody()->getContents());
                    return collect([]);
                }
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
     * @param array $Results
     * @return \Traversable
     */
    private function ToExchanges(array $Results): Traversable
    {
        throw new Exception("Not implemented");
    }

    public function GetStocksList($Exchange = null): Traversable
    {
        return collect([]);
    }

    /**
     *
     * @param                         $Stock
     * @param \DateTimeInterface      $From
     * @param \DateTimeInterface      $To
     * @param \App\Enum\TimeframeEnum $Timeframe
     * @return \Traversable
     */
    public function GetStockData($Stock, DateTimeInterface $From, DateTimeInterface $To, TimeframeEnum $Timeframe): Traversable
    {
        return collect([]);
    }

    private function GetExchangesFromListings(): iterable
    {
        $Results = Util::ArrayFromCSV(Storage::disk('local')->path(ProviderEnum::alphavantage()->toName() . '_listings.csv'), true);
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
}
