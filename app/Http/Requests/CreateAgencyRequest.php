<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateAgencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $isAuthorizedUser = User::where('id', Auth::id())->where('role_id',UserRole::ROLE_SYSTEM_ADMIN)->exists();
        return $isAuthorizedUser;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:25"],
            "short_name" => ["required", "unique:agencies", "min:3", "max:20"],
            "address" => ["nullable", "min:2", "max:255"],
            "district_id" => ["required", "exists:districts,id"],
            "email" => ["nullable", "email", "unique:agencies"],
            "phone_no" => ["required", "unique:agencies", "regex:/^\d{10}$/"],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Agency Name is required",
            "district_id.required" => "Please select District",
            "short_name.required" => "Short Name is required",
            "phone_no.required" => "Phone number is required",

            "name.min" => "Name must be at least 3 characters",
            "name.max" => "Name must be at most 25 characters",

            "short_name.unique" => "Short Name already exist",
            "short_name.min" => "Short Name must be at least 3 characters",
            "short_name.max" => "Short Name must be at most 25 characters",
            
            "address.min" => "Address must be at least 3 characters",
            "address.max" => "Address must be at most 25 characters",

            "district_id.exists" => "District does not exist",

            "email.email" => "Email must be valid",
            "email.unique" => "Email already exists",
            
            "phone_no.unique" => "Phone number already exist",
            'phone_no.regex' => 'The phone number must be a 10-digit number'
        ];
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}
