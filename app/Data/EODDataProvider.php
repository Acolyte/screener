<?php

namespace App\Data;

use ArrayAccess;
use DateTimeInterface;

class EODDataProvider implements DataProvider
{
    public function __construct($config)
    {

    }

    /**
     * Calls https://eodhistoricaldata.com/api/exchanges-list/?api_token={YOUR_API_KEY}&fmt=json
     * @return iterable
     */
    public function GetExchanges(): iterable
    {
        // TODO: Implement GetExchanges() method.
    }

    /**
     * Calls https://eodhistoricaldata.com/api/exchange-symbol-list/{EXCHANGE_CODE}?api_token={YOUR_API_KEY}
     * @param null $Exchange
     * @return iterable
     */
    public function GetStocksList($Exchange = null): iterable
    {
        // TODO: Implement GetStocksList() method.
    }

    /**
     * Calls https://eodhistoricaldata.com/api/eod-bulk-last-day/{EXCHANGE_CODE}?api_token={YOUR_API_KEY}
     *
     * @param                    $Stock
     * @param \DateTimeInterface $Date
     * @param                    $Period
     * @param                    $Filters
     * @return \ArrayAccess
     */
    public function GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters): ArrayAccess
    {
        // TODO: Implement GetStockData() method.
    }

}
