<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateBandRequest extends FormRequest
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
            'name'=>'required|string',
            'description'=>'required|string',
            'biography'=>'required|string',
            'image'=>'required|image|mimes:jpg,png',
            'text_color'=>'nullable|string',
            'background_color'=>'nullable|string',
            'embed_url'=>'required|array',
            'embed_url.*'=>'required|string',
        ];
    }
}
