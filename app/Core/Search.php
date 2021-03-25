<?php
declare(strict_types=1);

namespace App\Core;

use App\Enum\AnalysisEnum;
use App\Enum\ProviderEnum;
use App\Enum\TimeframeEnum;
use App\Models\Stock;
use App\Models\Tick;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

class Search
{
    public static array $MODULA_UP = [
        'a' => [-0, 0], 'b' => [1, 5], 'c' => [6, 10], 'd' => [11, 15], 'e' => [16, 20], 'f' => [21, 25],
        'g' => [26, 30], 'h' => [31, 35], 'i' => [36, 40], 'j' => [41, 45], 'k' => [46, 50],
        'l' => [51, 55], 'm' => [56, 60], 'n' => [61, 65], 'o' => [66, 70], 'p' => [71, 75],
        'q' => [76, 80], 'r' => [81, 85], 's' => [86, 90], 't' => [91, 95], 'u' => [96, 100], 'v' => [101, 125],
        'w' => [126, 150], 'x' => [151, 175], 'y' => [176, 200],
        'z' => [201, PHP_INT_MAX]];

    public static array $MODULA_DOWN = [
        'a' => [0, -0], 'b' => [-1, -5], 'c' => [-6, -10], 'd' => [-11, -15], 'e' => [-16, -20], 'f' => [-21, -25],
        'g' => [-26, -30], 'h' => [-31, -35], 'i' => [-36, -40], 'j' => [-41, -45], 'k' => [-46, -50],
        'l' => [-51, -55], 'm' => [-56, -60], 'n' => [-61, -65], 'o' => [-66, -70], 'p' => [-71, -75],
        'q' => [-76, -80], 'r' => [-81, -85], 's' => [-86, -90], 't' => [-91, -95], 'u' => [-96, -100],
        'v' => [-101, -125], 'w' => [-126, -150], 'x' => [-151, -175], 'y' => [-176, -200],
        'z' => [-201, PHP_INT_MIN]];


    /**
     * @var \App\Models\Stock $Stock
     */
    private Stock $Stock;

    /**
     * @var \DateTimeInterface
     */
    private DateTimeInterface $From;

    /**
     * @var \DateTimeInterface
     */
    private DateTimeInterface $To;

    /**
     * @var \App\Enum\TimeframeEnum
     */
    private TimeframeEnum $Tick;

    /**
     * @var \App\Enum\AnalysisEnum
     */
    private AnalysisEnum $Analysis;

    public function __construct(Stock $Stock, DateTimeInterface $From, DateTimeInterface $To,
                                TimeframeEnum $Tick, AnalysisEnum $Analysis)
    {
        $this->Stock = $Stock;
        $this->From = $From;
        $this->To = $To;
        $this->Tick = $Tick;
        $this->Analysis = $Analysis;
    }

    public function Search(): string
    {
        $CacheKey = sprintf('p_%s_exc_%s_stk_%s_frm_%s_to_%s_tck_%s',
            ProviderEnum::eod()->toCode(), $this->Stock->exchange->code, $this->Stock->code,
            $this->From->format('dmyy'), $this->To->format('dmyy'), $this->Tick->toCode());

        if (Cache::has($CacheKey)) {
            $StringData = Cache::get($CacheKey);
        } else {
            $Data = $this->GetData();
            $StringData = $this->Modulate($Data);
            Cache::put($CacheKey, $StringData, now()->addDay());
        }

        return $StringData;
    }

    private function GetData(): array
    {
        $TickData = Tick::query()->where('stock_id', $this->Stock->id)
                        ->whereBetween('date', [$this->From, $this->To])
                        ->where('timeframe', (string)$this->Tick->toId());
        switch ($this->Analysis) {
            case AnalysisEnum::hl():
                $TickData = $TickData->select('high', 'low')->get();
                return $TickData->map(function (Tick $Entry)
                {
                    return round(($Entry->low + $Entry->high) / 2, 6);
                })->toArray();
            case AnalysisEnum::hlc():
                $TickData = $TickData->select('high', 'low', 'close')->get();
                return $TickData->map(function (Tick $Entry)
                {
                    return round(($Entry->high + $Entry->low + $Entry->close) / 3, 6);
                })->toArray();
            case AnalysisEnum::ohlc():
                $TickData = $TickData->select('open', 'high', 'low', 'close')->get();
                return $TickData->map(function (Tick $Entry)
                {
                    return round(($Entry->open + $Entry->close + $Entry->low + $Entry->high) / 4, 6);
                })->toArray();
        }

        return [];
    }

    private function Modulate(array $Data): string
    {
        $Response = [];

        for ($Index = 0; $Index < count($Data) - 1; $Index++) {
            $Current = $Data[$Index];
            $Next = $Data[$Index + 1];
            if ($Current == 0) {
                $Response[$Index] = 0;
                continue;
            }
            $Result = (($Next - $Current) / $Current) * 100;
            $Diff = ($Result > 0) ? floor($Result) : ceil($Result);
            if ($Diff == 0) {
                $Response[$Index] = 'a';
            } else {
                if ($Diff > 0) {
                    foreach (self::$MODULA_UP as $Key => $Values) {
                        if ($Diff >= $Values[0] && $Diff < $Values[1]) {
                            $Response[$Index] = $Key;
                        }
                    }
                } else {
                    if ($Diff < 0) {
                        foreach (self::$MODULA_DOWN as $Key => $Values) {
                            if ($Diff <= $Values[0] && $Diff > $Values[1]) {
                                $Response[$Index] = $Key;
                            }
                        }
                    }
                }
            }
        }

        return implode('', $Response);
    }
}
