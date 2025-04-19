<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'discount_percentage' => 'required|numeric|max:60',
            'product_id' => 'required|exists:products,id',
        ];
    }
}
