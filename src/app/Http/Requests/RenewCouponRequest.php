<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenewCouponRequest extends FormRequest
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
            'discount_percentage' => 'sometimes|numeric|max:60',
            'start_date' => 'required|date|after:+10 seconds',
            'end_date' => 'required|date|after:start_date'
        ];
    }
}
