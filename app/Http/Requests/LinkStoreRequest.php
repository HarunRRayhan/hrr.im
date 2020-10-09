<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    public function prepareForValidation()
    {
        // prefix protocol for full link if missing
        if ( $this->filled( 'full_link' ) && ! Str::startsWith( $url = $this->get( 'full_link' ), [
                'http://',
                'https://'
            ] ) ) {
            $this->merge( [ 'full_link' => "http://$url" ] );
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label'       => [ 'required', 'string', 'max:256' ],
            'full_link'   => [ 'required', 'url', 'max:256' ],
            'slug'        => [ 'nullable', 'alpha_dash', 'unique:links' ],
            'description' => [ 'nullable', 'string' ],
            'private'     => [ 'nullable', 'boolean' ],
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param array|mixed|null $keys
     *
     * @return array
     */
    public function all( $keys = null )
    {
        $all = parent::all( $keys );
        if ( ! empty( $all['private'] ) && $all['private'] ) {
            $all['secret'] = Str::random( 6 );
            unset( $all['private'] );
        }

        return collect( $all )->filter()->toArray();
    }
}
