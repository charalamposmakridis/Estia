<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()!==null;
    }

    protected function prepareForValidation(): void
    {

        $this->merge([
            'check_in' => $this->check_in ? $this->check_in . ' 14:00:00' : null,
            'check_out' => $this->check_out ? $this->check_out . ' 11:00:00' : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'check_in' => ['required', 'date_format:Y-m-d H:i:s', 'after:today'],
            'check_out' => ['required', 'date_format:Y-m-d H:i:s', 'after:check_in'],
        ];
    }
}
