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
        $rules = [
            'name'=>'required|string',
            'description'=>'required|string',
            'biography'=>'required|string',
            'text_color'=>'nullable|string',
            'background_color'=>'nullable|string',
            'embed_url'=>'required|array',
            'embed_url.*'=>'required|string',
        ];

        if(!is_null($this->route('band'))){
            $rules['image'] = 'nullable|image|mimes:jpg,png';
        } else {
            $rules['image'] = 'required|image|mimes:jpg,png';
        }

        return $rules;
    }
}
