<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateWpsRequest extends FormRequest
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
            "address" => ["nullable", "min:2", "max:255"],
            "district_id" => ["required", "exists:districts,id"],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Women Police Station name is required",
            "district_id.required" => "Please select District",

            "name.min" => "Name must be at least 3 characters",
            "name.max" => "Name must be at most 25 characters",

            "address.min" => "Address must be at least 3 characters",
            "address.max" => "Address must be at most 25 characters",

            "district_id.exists" => "District does not exist",
        ];
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}
