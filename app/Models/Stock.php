<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stock
 *
 * @property int $id
 * @property string $symbol
 * @property int $exchange_id
 * @property string $type
 * @property string $name
 * @property bool $active
 * @property \Illuminate\Support\Carbon $ipoAt
 * @property \Illuminate\Support\Carbon|null $delistedAt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Exchange $exchange
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereDelistedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereExchangeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereIpoAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stock extends Model
{
    public $table = 'stocks';

    public $fillable = ['symbol', 'exchange_id', 'type', 'name', 'active', 'ipoAt', 'delistedAt'];
    public $dates    = ['ipoAt', 'delistedAt'];

    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }
}
