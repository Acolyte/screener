<?php
declare(strict_types=1);

namespace App\Data;

use App\Enum\TimeframeEnum;
use DateTimeInterface;

class Ticker
{
    /**
     * @var int $StockID
     */
    public int $StockID;
    /**
     * @var TimeframeEnum $Timeframe
     */
    public TimeframeEnum $Timeframe;
    /**
     * @var DateTimeInterface $Date
     */
    public DateTimeInterface $Date;
    /**
     * @var float $Open
     */
    public float $Open;
    /**
     * @var float $Close
     */
    public float $Close;
    /**
     * @var float $Low
     */
    public float $Low;
    /**
     * @var float $High
     */
    public float $High;
    /**
     * @var int $Volume
     */
    public int $Volume;

    public function __construct(int $StockID, TimeframeEnum $Timeframe, DateTimeInterface $Date,
                                float $Open, float $Close, float $Low, float $High, int $Volume)
    {
        $this->StockID = $StockID;
        $this->Timeframe = $Timeframe;
        $this->Date = $Date;
        $this->Open = $Open;
        $this->Close = $Close;
        $this->Low = $Low;
        $this->High = $High;
        $this->Volume = $Volume;
    }
}
