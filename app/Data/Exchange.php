<?php


namespace App\Data;

class Exchange
{
    /**
     * @var string $Code
     */
    public $Code;
    /**
     * @var string $Name
     */
    public $Name;
    /**
     * @var null|int $CountryID
     */
    public $CountryID;
    /**
     * @var null|int $CurrencyID
     */
    public $CurrencyID;
    /**
     * @var null|string $MICs
     */
    public $MICs;

    public function __construct(string $Code, string $Name,
                                ?int $CountryID = null, ?int $CurrencyID = null, ?string $MICs = null)
    {
        $this->Code = $Code;
        $this->Name = $Name;
        $this->CountryID = $CountryID;
        $this->CurrencyID = $CurrencyID;
        $this->MICs = $MICs;
    }
}
