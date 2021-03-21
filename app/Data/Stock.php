<?php
declare(strict_types=1);

namespace App\Data;

use DateTimeInterface;

class Stock
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
     * @var int $ExchangeID
     */
    public int $ExchangeID;
    /**
     * @var int Type
     */
    public int $Type;
    /**
     * @var bool $Active
     */
    public bool $Active;
    /**
     * @var null|string $SubExchange
     */
    public ?string $SubExchange;
    /**
     * @var null|\DateTimeInterface $IPOAt
     */
    public ?DateTimeInterface $IPOAt;
    /**
     * @var null|\DateTimeInterface $DelistedAt
     */
    public ?DateTimeInterface $DelistedAt;

    public function __construct(int $ExchangeID, string $Code, string $Name, int $Type,
                                ?string $SubExchange = null,
                                bool $Active = true,
                                ?DateTimeInterface $IPOAt = null,
                                ?DateTimeInterface $DelistedAt = null)
    {
        $this->Code = $Code;
        $this->ExchangeID = $ExchangeID;
        $this->Name = $Name;
        $this->Type = $Type;
        $this->Active = $Active;
        $this->SubExchange = $SubExchange;
        $this->IPOAt = $IPOAt;
        $this->DelistedAt = $DelistedAt;
    }
}
