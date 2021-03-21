<?php
declare(strict_types=1);

namespace App\Data;

class Exchange
{
    /**
     * @var string $Code
     */
    public string $Code;
    /**
     * @var string $Name
     */
    public string $Name;
    /**
     * @var null|int $CountryID
     */
    public ?int $CountryID;
    /**
     * @var null|int $CurrencyID
     */
    public ?int $CurrencyID;
    /**
     * @var null|string $MICs
     */
    public ?string $MICs;

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
