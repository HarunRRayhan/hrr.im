<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Models\LinkStatistic
 *
 * @property int $id
 * @property int $link_id
 * @property string|null $referer
 * @property string|null $slug
 * @property string $to
 * @property string|null $user_agent
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon $opened_at
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereOpenedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereReferer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereUserAgent($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Link $link
 * @property int $success
 * @method static \Illuminate\Database\Eloquent\Builder|LinkStatistic whereSuccess($value)
 */
class LinkStatistic extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'opened_at'
    ];

    public $timestamps = false;

    public function link(): BelongsTo
    {
        return $this->belongsTo( Link::class );
    }
}
