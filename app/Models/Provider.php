<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Provider
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exchange[] $exchanges
 * @property-read int|null                                                        $exchanges_count
 * @method static Builder|Provider newModelQuery()
 * @method static Builder|Provider newQuery()
 * @method static Builder|Provider query()
 * @mixin \Eloquent
 * @property int                                                                  $id
 * @property string                                                               $code Data provider code (av, eod)
 * @property string                                                               $name Data provider name (Alpha
 *           Vantage, Quandl, EOD)
 * @property string                                                               $site Data provider official site
 * @property string|null                                                          $key  Data provider API key
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @method static Builder|Provider whereCode($value)
 * @method static Builder|Provider whereCreatedAt($value)
 * @method static Builder|Provider whereId($value)
 * @method static Builder|Provider whereKey($value)
 * @method static Builder|Provider whereName($value)
 * @method static Builder|Provider whereSite($value)
 * @method static Builder|Provider whereUpdatedAt($value)
 */
class Provider extends Model
{
    public $table = 'providers';

    protected $fillable = ['code', 'name', 'site', 'key'];

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
}
