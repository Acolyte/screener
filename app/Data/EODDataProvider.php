<?php
declare(strict_types=1);

namespace App\Data;

use App\Enum\ProviderEnum;
use App\Enum\TimeframeEnum;
use App\Models\Currency;
use Carbon\Carbon;
use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Traversable;

class EODDataProvider implements DataProvider
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return \Traversable
     */
    public function GetExchanges(): Traversable
    {
        $Filename = ProviderEnum::eod()->toName() . '_exchanges.bson';
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

    /**
     * Calls https://eodhistoricaldata.com/api/exchange-symbol-list/{EXCHANGE_CODE}?api_token={YOUR_API_KEY}
     * @param null $Exchange
     * @return \Traversable
     */
    public function GetStocksList($Exchange = null): Traversable
    {
        if (is_null($Exchange)) {
            Log::error('Cannot retrieve stocks without exchange with provider ' . ProviderEnum::eod()->toName());
            return collect([]);
        }

        $Filename = ProviderEnum::eod()->toName() . '_exchange_' . $Exchange->code . '_stocks.bson';
        if (Storage::disk('local')->exists($Filename)) {
            return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
        } else {
            $Client = new Client();
            $URL = $this->config['urls']['stocks'];
            foreach (['{EXCHANGE_CODE}' => $Exchange->code, '{EOD_API_KEY}' => $this->config['key']] as $Search => $Replace) {
                $URL = str_replace($Search, $Replace, $URL);
            }

            try {
                $JSON = $Client->get($URL);
                if ($JSON->getStatusCode() === 200) {
                    $Results = json_decode($JSON->getBody()->getContents(), false);
                    $Stocks = $this->ToStocks($Exchange, $Results);
                    Storage::disk('local')->put($Filename, igbinary_serialize($Stocks));
                    return collect(igbinary_unserialize(Storage::disk('local')->get($Filename)));
                } else {
                    Log::error($JSON->getBody()->getContents());
                    return collect([]);
                }
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
     * @param \App\Models\Exchange $Exchange
     * @param array                $Results
     * @return \Traversable
     */
    private function ToStocks(\App\Models\Exchange $Exchange, array $Results): Traversable
    {
        $Response = [];
        foreach ($Results as $Result) {
            $Type = 0;
            foreach (config('enums.stock') as $name => $value) {
                if (strtolower($Result->Type) === strtolower($name)) {
                    $Type = $value;
                    break;
                }
            }
            if ($Type === 0) {
                Log::error('Failed to deduct stock type from value of ' . $Result->Type);
                continue;
            }

            $Response[] = new Stock($Exchange->id, $Result->Code,
                $Result->Name, $Type, $Result->Exchange);
        }

        return collect($Response);
    }

    /**
     * Calls https://eodhistoricaldata.com/api/eod-bulk-last-day/{EXCHANGE_CODE}?api_token={YOUR_API_KEY}
     *
     * @param                         $Stock
     * @param \DateTimeInterface      $From
     * @param \DateTimeInterface      $To
     * @param \App\Enum\TimeframeEnum $Timeframe
     * @return \Traversable
     */
    public function GetStockData(\App\Models\Stock $Stock, DateTimeInterface $From,
                                 DateTimeInterface $To, TimeframeEnum $Timeframe): Traversable
    {
        if (is_null($Stock)) {
            Log::error('Cannot retrieve stock data without actual stock');
            return collect([]);
        }

        $Client = new Client();
        $URL = $this->config['urls']['data']['symbol-history'];
        foreach (['{STOCK_CODE}'    => $Stock->code,
                  '{EXCHANGE_CODE}' => $Stock->exchange()->code,
                  '{FROM_DATE}'     => $From->format('yyyy-mm-dd'),
                  '{TO_DATE}'       => $To->format('yyyy-mm-dd'),
                  '{PERIOD}'        => $Timeframe->toName(),
                  '{EOD_API_KEY}'   => $this->config['key']] as $Search => $Replace) {
            $URL = str_replace($Search, $Replace, $URL);
        }

        try {
            $JSON = $Client->get($URL);
            if ($JSON->getStatusCode() === 200) {
                $Results = json_decode($JSON->getBody()->getContents(), false);
                return $this->ToTickers($Stock, $Timeframe, $Results);
            } else {
                Log::error($JSON->getBody()->getContents());
                return collect([]);
            }
        }
        catch(GuzzleException $ex) {
            Log::error('Failed to fetch stock data for ' . $Stock->name . ' stock with ' . $this->config['name'] . ' provider', ['message' => $ex->getMessage()]);
        }
        catch(Throwable $ex) {
            Log::error('Failed to save stock data response from ' . $Stock->name . ' stock with ' . $this->config['name'] . ' provider to storage', ['message' => $ex->getMessage()]);
        }

        return collect([]);
    }

    /**
     * @param \App\Models\Stock       $Stock
     * @param \App\Enum\TimeframeEnum $Timeframe
     * @param array                   $Results
     * @return \Traversable
     */
    private function ToTickers(\App\Models\Stock $Stock, TimeframeEnum $Timeframe, array $Results): Traversable
    {
        $Response = [];
        foreach ($Results as $Result) {
            $Ticker = new Ticker($Stock->id, $Timeframe, Carbon::parse($Result->date),
                floatval($Result->open), floatval($Result->close),
                floatval($Result->low), floatval($Result->close), intval($Result->volume));
            $Response[] = $Ticker;
        }

        return collect($Response);
    }
}
