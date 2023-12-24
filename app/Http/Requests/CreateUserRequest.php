<?php

namespace App\Http\Requests;

use App\Models\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:25'],
            'username' => ['required', 'min:4', 'max:25', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'regex:/^\d{10}$/', 'unique:users'],
            'role_id' => ['required', 'exists:user_roles,id'],
            'agency_id' => ['nullable', 'required_if:role_id,'.UserRole::ROLE_AGENCY_MANAGER, 'exists:agencies,id'],
            'counselling_centre_id' => ['nullable', 'required_if:role_id,'.UserRole::ROLE_COUNSELLING_CENTRE_ADMIN, 'exists:counselling_centres,id'],
            'women_police_station_id' => ['nullable', 'required_if:role_id,'.UserRole::ROLE_WPS_ADMIN, 'exists:women_police_stations,id'],
        ];
    }

    public function messages()
    {
        return [
            'agency_id.required_if' => 'please select agency',
            'counselling_centre_id.required_if' => 'please select counselling centre',
            'women_police_station_id.required_if' => 'please select WPS',
        ];
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}
