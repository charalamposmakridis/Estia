<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user=$this->user();
        if(!$user){return false;}

        $listingId=$this->route('listing_id');
        $listing=Listing::find($listingId);

        if(!$listing ||$listing->user_id===$user->id){return false;}

        $hasValidBooking=Booking::where('user_id',$user->id)
            ->where('listing_id',$listingId)
            ->where('status','confirmed')
            ->exists();

        return $hasValidBooking;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'listing_id'=>['required','exists:listings,id'],
            'rating'=>['required','integer','min:1','max:5'],
            'comment'=>['required','string','max:1000']
        ];
    }
}
