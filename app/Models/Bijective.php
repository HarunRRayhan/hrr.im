<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Bijective
 *
 * @property int $id
 * @property int $index
 * @method static \Illuminate\Database\Eloquent\Builder|Bijective newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bijective newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bijective query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bijective whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bijective whereIndex($value)
 * @mixin \Eloquent
 */
class Bijective extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'index' => 'integer'
    ];

    protected $guarded = [];

}
