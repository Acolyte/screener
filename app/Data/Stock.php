<?php

namespace App\Data;

use DateTimeInterface;

class Stock
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
     * @var int $ExchangeID
     */
    public $ExchangeID;
    /**
     * @var int Type
     */
    public $Type;
    /**
     * @var bool $Active
     */
    public $Active;
    /**
     * @var null|\DateTimeInterface $IPOAt
     */
    public $IPOAt;
    /**
     * @var null|\DateTimeInterface $DelistedAt
     */
    public $DelistedAt;

    public function __construct(int $ExchangeID, string $Code, string $Name, int $Type,
                                bool $Active = true,
                                ?DateTimeInterface $IPOAt = null,
                                ?DateTimeInterface $DelistedAt = null)
    {
        $this->Code = $Code;
        $this->ExchangeID = $ExchangeID;
        $this->Name = $Name;
        $this->Type = $Type;
        $this->Active = $Active;
        $this->IPOAt = $IPOAt;
        $this->DelistedAt = $DelistedAt;
    }
}
