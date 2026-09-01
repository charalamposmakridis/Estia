<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>['sometimes','required','string','max:255'],
            'description'=>['sometimes','required','string','min:10'],
            'country'=>['sometimes','required','string','max:255'],
            'city'=>['sometimes','required','string','max:255'],
            'latitude'=>['sometimes','required','numeric','min:-90','max:90'],
            'longitude'=>['sometimes','required','numeric','min:-180','max:180'],
            'max_guests'=>['sometimes','required','integer','min:1'],
            'price_per_night'=>['sometimes','required','numeric','min:0'],
            'cover_image'=>['sometimes','required','image','mimes:png,jpg,jpeg','max:2048']
        ];
    }
}
