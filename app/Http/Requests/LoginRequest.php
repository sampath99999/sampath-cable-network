<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
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
            "username" => ["required", "min:3", "max:25", "exists:users"],
            "password" => ["required", "min:3", "max:25"]
        ];
    }

    public function messages(): array
    {
        return [
            "username.required" => "Username is required",
            "password.required" => "Password is required",

            "username.min" => "Username must be at least 3 characters",
            "password.min" => "Password must be at least 3 characters",

            "username.max" => "Username must be at most 25 characters",
            "password.max" => "Password must be at most 25 characters",

            "username.exists" => "Username or Password is incorrect"
        ];
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}
