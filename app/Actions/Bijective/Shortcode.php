<?php


namespace App\Actions\Bijective;

use App\Models\Bijective;
use Bijective\BijectiveTranslator;

class Shortcode
{
    public static function get(): string
    {
        $bijective = Bijective::firstOrNew();
        $lastIndex = optional( $bijective )->index ?? 0;
        $index     = ++ $lastIndex;

        $translator = resolve( BijectiveTranslator::class );
        $code       = $translator->encode( $index );

        $bijective->index = $index;
        $bijective->save();

        return $code;
    }
}
