<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'description' => 'sometimes|string|max:280',
            'start_date' => 'sometimes|date|after:+10 seconds',
            'end_date' => 'sometimes|date|after:start_date',
            'discount_percentage' => 'sometimes|numeric|max:60',
            'product_id' => 'sometimes|exists:products,id',
        ];
    }
}
