<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\Helper;
use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LinkUpdateRequest extends FormRequest
{
    use Helper;

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
        $this->removeEmpty( 'label', 'slug', 'full_link' );
        $this->prefixFullLinkProtocol();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        return [
            'label'       => [ 'sometimes', 'required', 'string', 'max:256' ],
            'full_link'   => [ 'sometimes', 'required', 'url', 'max:256' ],
            'slug'        => [
                'sometimes',
                'alpha_dash',
                Rule::unique( 'links' )->ignore( $this->link )
            ],
            'description' => [ 'nullable', 'string' ],
            'private'     => [ 'sometimes', 'boolean' ],
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        if ( isset( $validated['private'] ) ) {
            $validated['secret'] = ! empty( $validated['private'] ) && $validated['private'] ? Str::random( 6 ) : null;
            unset( $validated['private'] );
        }

        return collect( $validated )
            ->filter( function ( $value, $key ) {
                if ( in_array( $key, [ 'description', 'secret' ] ) ) {
                    return true;
                }

                return (bool) $value;
            } )
            ->toArray();
    }

}
