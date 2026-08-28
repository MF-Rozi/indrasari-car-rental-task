<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $carId = $this->route('car') ? $this->route('car')->id : null;

        return [
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'license_plate' => [
                'required',
                'string',
                'max:50',
                Rule::unique('cars', 'license_plate')->ignore($carId),
            ],
            'daily_rate' => ['required', 'integer', 'min:10000'],
            'transmission' => ['required', 'string', 'in:Automatic,Manual'],
            'seating_capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'status' => ['required', 'string', 'in:available,rented,maintenance'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    /**
     * Custom validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'license_plate.unique' => 'This license plate is already registered to another vehicle.',
            'daily_rate.min' => 'Daily rate must be at least Rp 10.000.',
            'image.max' => 'Car image must not exceed 2MB in file size.',
            'image.mimes' => 'Car image must be a JPEG, PNG, JPG, or WebP file.',
        ];
    }
}
