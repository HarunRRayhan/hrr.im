<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkStoreRequest extends FormRequest
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
            'label'       => [ 'required', 'string', 'max:256' ],
            'full_link'   => [ 'required', 'url', 'max:256' ],
            'slug'        => [ 'nullable', 'alpha_dash', 'unique:links' ],
            'description' => [ 'nullable', 'string' ],
            'private'     => [ 'sometimes', 'boolean' ],
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();
        if ( ! empty( $validated['private'] ) && $validated['private'] ) {
            $validated['secret'] = Str::random( 6 );
            unset( $validated['private'] );
        }

        return collect( $validated )->filter()->toArray();
    }
}
