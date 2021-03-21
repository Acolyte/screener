<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int                                                                  $id
 * @property string                                                               $name
 * @property string                                                               $isoCode
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereIsoCode($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exchange[] $exchanges
 * @property-read int|null                                                        $exchanges_count
 */
class Country extends Model
{
    protected $table    = 'countries';
    protected $fillable = ['isoCode', 'name', 'date_formats'];

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
}
