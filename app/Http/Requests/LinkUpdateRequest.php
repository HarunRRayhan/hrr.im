<?php

namespace App\Http\Requests;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LinkUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function prepareForValidation(): void
    {
        $this->removeEmpty( 'label' );
        $this->prefixFullLinkProtocol();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Link $link
     *
     * @return array
     */
    public function rules( Link $link ): array
    {
        return [
            'label'       => [ 'nullable', 'string', 'max:256' ],
            'full_link'   => [ 'sometimes', 'required', 'url', 'max:256' ],
            'slug'        => [
                'sometimes',
                'alpha_dash',
                Rule::unique( 'links' )->ignore( $link )
            ],
            'description' => [ 'sometimes', 'string' ],
            'private'     => [ 'sometimes', 'boolean' ],
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param array|mixed|null $keys
     *
     * @return array
     */
    public function all( $keys = null ): array
    {
        $all = parent::all( $keys );
        if ( ! empty( $all['private'] ) && $all['private'] ) {
            $all['secret'] = Str::random( 6 );
            unset( $all['private'] );
        }

        return collect( $all )->filter()->toArray();
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
