<?php

namespace App\Models;

use App\Actions\Bijective\Shortcode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

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
 * @property-read bool $is_public
 * @property-read string $shortlink
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LinkStatistic[] $statistics
 * @property-read int|null $statistics_count
 */
class Link extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    protected $appends = [ 'shortlink', 'is_public' ];

    protected static function boot()
    {
        parent::boot();

        static::creating( function ( self $link ) {
            if ( $link->slug ) {
                return;
            }

            do {
                $code     = Shortcode::get();
                $existing = $link->whereSlug( $code )->first();
                if ( ! $existing ) {
                    break;
                }
            } while ( true );

            $link->slug = $code;
        } );
    }

    public function getShortlinkAttribute(): string
    {
        return route( 'shortlink', [ 'link' => $this->slug, 'secret' => $this->secret ] );
    }

    public function getIsPublicAttribute(): bool
    {
        return (bool) ! $this->secret;
    }

    public function toSearchableArray(): array
    {
        return $this->only( [ 'id', 'label', 'slug', 'full_link' ] );
    }

    public function statistics(): HasMany
    {
        return $this->hasMany( LinkStatistic::class );
    }
}
