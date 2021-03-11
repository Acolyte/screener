<?php

namespace App\Services;

use GuzzleHttp\Client;

class StockDownload
{
    public const ALPHA_VANTAGE = 'alpha_vantage';

    private const ALPHA_VANTAGE_STOCKS_URL = 'https://www.alphavantage.co/query?function=LISTING_STATUS&apikey=';
    /**
     * @var array $config
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download()
    {
        $client = new Client();
        foreach ($this->config['type'] as $service => $serviceConfig) {
            switch ($service) {
                case self::ALPHA_VANTAGE:
                {
                    $client->get(self::ALPHA_VANTAGE_STOCKS_URL . $serviceConfig['key'],
                        ['timeout' => 2, 'sink' => storage_path('stock/' . self::ALPHA_VANTAGE . '.csv')
                        ]);
                }
            }
        }
    }
}
