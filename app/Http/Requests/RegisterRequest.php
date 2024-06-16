<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:255'],
            'password' => ['required', Password::default()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'message' => $validator->errors()->first()
        ], 422));
    }
}
