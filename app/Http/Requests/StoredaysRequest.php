<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoredaysRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','min:6','max:9']//shortest day name has 6 letters , longest day name has 9 letters
        ];
    }
}
