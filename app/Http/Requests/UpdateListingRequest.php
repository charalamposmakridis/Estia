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
            'title'=>['sometimes','string','max:255'],
            'description'=>['sometimes','string','min:10'],
            'country'=>['sometimes','string','max:255'],
            'city'=>['sometimes','string','max:255'],
            'latitude'=>['sometimes','numeric','min:-90','max:90'],
            'longitude'=>['sometimes','numeric','min:-180','max:180'],
            'max_guests'=>['sometimes','integer','min:1'],
            'price_per_night'=>['sometimes','numeric','min:0'],
            'cover_image'=>['sometimes','image','mimes:png,jpg,jpeg','max:2048']
        ];
    }
}
