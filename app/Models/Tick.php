<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StockHistory
 *
 * @method static Builder|Tick newModelQuery()
 * @method static Builder|Tick newQuery()
 * @method static Builder|Tick query()
 * @mixin \Eloquent
 * @property int                             $id
 * @property int|null                        $stock_id
 * @property int                             $timeframe
 * @property float                           $open
 * @property float                           $close
 * @property float                           $low
 * @property float                           $high
 * @property float                           $volume
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Stock|null     $stock
 * @method static Builder|Tick whereClose($value)
 * @method static Builder|Tick whereCreatedAt($value)
 * @method static Builder|Tick whereHigh($value)
 * @method static Builder|Tick whereId($value)
 * @method static Builder|Tick whereLow($value)
 * @method static Builder|Tick whereOpen($value)
 * @method static Builder|Tick whereStockId($value)
 * @method static Builder|Tick whereTimeframe($value)
 * @method static Builder|Tick whereVolume($value)
 * @property \Illuminate\Support\Carbon      $date
 * @method static Builder|Tick whereDate($value)
 */
class Tick extends Model
{
    protected $table = 'ticks';

    protected $fillable = ['stock_id', 'date', 'timeframe', 'open', 'close', 'low', 'high', 'volume'];
    protected $dates    = ['date'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
