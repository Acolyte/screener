<?php

namespace App\Models;

use App\Enum\StockEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Exchange
 *
 * @property int                                                               $id
 * @property string                                                            $name
 * @property \Illuminate\Support\Carbon|null                                   $created_at
 * @property \Illuminate\Support\Carbon|null                                   $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $etfs
 * @property-read int|null                                                     $etfs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read int|null                                                     $stocks_count
 * @method static Builder|Exchange newModelQuery()
 * @method static Builder|Exchange newQuery()
 * @method static Builder|Exchange query()
 * @method static Builder|Exchange whereCreatedAt($value)
 * @method static Builder|Exchange whereId($value)
 * @method static Builder|Exchange whereName($value)
 * @method static Builder|Exchange whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string                                                            $code
 * @property-read \App\Models\Provider                                         $provider
 * @method static Builder|Exchange whereCode($value)
 * @property int                                                               $provider_id Data provider (Alpha Vantage, Quandl, EOD)
 * @method static Builder|Exchange whereProviderId($value)
 * @property int|null                                                          $country_id
 * @property int|null                                                          $currency_id
 * @property string|null                                                       $mics
 * @method static Builder|Exchange whereCountryId($value)
 * @method static Builder|Exchange whereCurrencyId($value)
 * @method static Builder|Exchange whereMics($value)
 */
class Exchange extends Model
{
    use HasFactory;

    public $table = 'exchanges';

    public $fillable = ['provider_id', 'country_id', 'currency_id', 'code', 'name', 'mics'];

    public function stocks()
    {
        return $this->hasMany(Stock::class)->where('type', StockEnum::stock()->value);
    }

    public function etfs()
    {
        return $this->hasMany(Stock::class)->where('type', StockEnum::etf()->value);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
