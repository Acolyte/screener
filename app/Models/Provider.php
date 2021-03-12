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
 */
class Provider extends Model
{
    public $table = 'providers';

    protected $fillable = ['name', 'site', 'key'];

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
}
