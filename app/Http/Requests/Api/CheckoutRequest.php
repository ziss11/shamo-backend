<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'exists:products,id'],
            'status' => ['required', 'in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED'],
            'total_price' => ['required', 'numeric'],
            'shipping_price' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => 'Alamat harus diisi',
            'items.required' => 'Items wajib diisi',
            'items.min' => 'Harus checkout minimal 1 item',
            'items.*.id.required' => 'Product wajib diisi',
            'items.*.id.exists' => 'Product tidak ditemukan',
            'status.required' => 'Status wajib diisi',
            'total_price.required' => 'Total price wajib diisi',
            'shipping_price.required' => 'Shipping price wajib diisi',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'message' => $validator->errors()->first()
        ], 422));
    }
}
