<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user=$this->user();
        if(!$user){
            return false;
        }

        $booking=$this->route('booking');
        if(!$booking){
            return false;
        }

        return $booking->user_id === $user->id || $booking->listing->user_id === $user->id;


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'check_in'=>['sometimes','required','date','after:today'],
            'check_out'=>['sometimes','required','date','after:check_in'],
            'status'=>['sometimes','required','in:pending,confirmed,rejected,cancelled']
        ];
    }
}
