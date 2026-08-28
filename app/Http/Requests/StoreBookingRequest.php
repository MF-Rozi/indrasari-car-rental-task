<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'integer', 'exists:cars,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ];
    }

    /**
     * Get custom error messages for validation exceptions.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'Pick-up date cannot be in the past.',
            'end_date.after_or_equal' => 'Return date must be on or after the pick-up date.',
        ];
    }
}
