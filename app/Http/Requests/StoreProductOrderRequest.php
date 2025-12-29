<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductOrderRequest extends FormRequest
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
            'prescription_id' => 'required|exists:prescriptions,id',

            'items' => 'required|array|min:1',

            'items.*.optical_product_id' =>
                'required|exists:optical_products,id',

            'items.*.quantity' =>'required|integer|min:1',
        ];
    }
}
