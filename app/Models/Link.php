<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property string|null $label
 * @property string $slug
 * @property string $full_link
 * @property string|null $secret
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereFullLink( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereLabel( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereSecret( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereSlug( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class Link extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [ 'shortlink' ];

    public function getShortlinkAttribute()
    {
        return route( 'shortlink', [ 'link' => $this->slug, 'secret' => $this->secret ] );
    }
}
