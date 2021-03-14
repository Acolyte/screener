<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stock
 *
 * @property int                                                              $id
 * @property string                                                           $symbol
 * @property int                                                              $exchange_id
 * @property string                                                           $type
 * @property string                                                           $name
 * @property bool                                                             $active
 * @property \Illuminate\Support\Carbon                                       $ipoAt
 * @property \Illuminate\Support\Carbon|null                                  $delistedAt
 * @property \Illuminate\Support\Carbon|null                                  $created_at
 * @property \Illuminate\Support\Carbon|null                                  $updated_at
 * @property-read \App\Models\Exchange                                        $exchange
 * @method static Builder|Stock newModelQuery()
 * @method static Builder|Stock newQuery()
 * @method static Builder|Stock query()
 * @method static Builder|Stock whereActive($value)
 * @method static Builder|Stock whereCreatedAt($value)
 * @method static Builder|Stock whereDelistedAt($value)
 * @method static Builder|Stock whereExchangeId($value)
 * @method static Builder|Stock whereId($value)
 * @method static Builder|Stock whereIpoAt($value)
 * @method static Builder|Stock whereName($value)
 * @method static Builder|Stock whereSymbol($value)
 * @method static Builder|Stock whereType($value)
 * @method static Builder|Stock whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tick[] $ticks
 * @property-read int|null                                                    $ticks_count
 * @property string                                                           $code
 * @method static Builder|Stock whereCode($value)
 */
class Stock extends Model
{
    public $table = 'stocks';

    public $fillable = ['code', 'exchange_id', 'type', 'name', 'active', 'ipo_at', 'delisted_at'];
    public $dates    = ['ipo_at', 'delisted_at'];

    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }

    public function ticks()
    {
        return $this->hasMany(Tick::class);
    }
}
