<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user=$this->user();
        if(!$user){return false;}


        $review=$this->route('review');
        if(!$review){return false;}

        return $review->user_id===$user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating'=>['sometimes','required','integer','min:1','max:5'],
            'comment'=>['sometimes','required','string','max:1000']
        ];
    }
}
