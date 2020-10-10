<?php
/**
 * @author HarunRRayhan/HRXPlugins
 * @url http://hrxplugins.com/
 * @version 1.0
 * File: Helper.php
 * @FileVersion: 1.0
 * Created On: 10/10/20:5:13 pm 10/10/2020
 * Updated On: 10/10/20:5:13 pm 10/10/2020
 * @package: @awesome-logo-slider-pro
 */

namespace App\Http\Requests\Concerns;


use App\Http\Requests\LinkUpdateRequest;
use Illuminate\Support\Str;

trait Helper
{

    protected function removeEmpty( ...$items ): LinkUpdateRequest
    {
        if ( ! $items ) {
            return $this;
        }

        foreach ( $items as $item ) {
            if (
                $this->has( $item ) &&
                ! $this->get( $item )
            ) {
                $this->request->remove( $item );
            }
        }

        return $this;
    }

    protected function prefixFullLinkProtocol(): self
    {
        if (
            $this->filled( 'full_link' ) &&
            ! Str::startsWith( $url = $this->get( 'full_link' ), [
                'http://',
                'https://'
            ] )
        ) {
            $this->merge( [ 'full_link' => "http://$url" ] );
        }

        return $this;
    }
}
