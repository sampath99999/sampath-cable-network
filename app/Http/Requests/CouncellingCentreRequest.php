<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CouncellingCentreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $isAuthorizedUser = User::where('id', Auth::id())->where('role_id', UserRole::ROLE_SYSTEM_ADMIN)->exists();
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
            'centreName' => 'required|string|min:3|max:25',
            'address' => 'nullable|min:3|max:25',
            'districtId' => 'required| exists:districts,id',
            'email' => 'nullable|unique:counselling_centres,email',
            'phoneNo' => 'required|unique:counselling_centres,phone_no|digits:10|numeric|regex:/^[0-9]+$/',
            'agencyId' => 'required',
            'isVirtual' => 'required',
            'isPhysical' => 'required',
            'canCreateCase' => 'required',
            'hasFco' => 'required',
            'hasCounsellor' => 'required',

        ];
    }

    public function messages()
    {
        return [

            'centreName.required' => 'The CentreName field is required.',
            'centreName.string' => 'The name must be  character.',
            "centreName.min" => "centreName must be at least 3 characters",
            "centreName.max" => "centreName must be at most 25 characters",
            "address.min" => "Address must be at least 3 characters",
            "address.max" => "Address must be at most 25 characters",
            'districtId.required' => 'The district field is required.',
            "districtId.exists" => "District does not exist",

            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already exists.',
            'phoneNo.required' => 'The phone number field is required.',
            'phoneNo.required' => 'The phone number field is required.',
            'phoneNo.digits' => 'The phone number must be exactly 10 digits.',
            'phoneNo.numeric' => 'The phone number must be numeric.',
            'phoneNo.unique' => 'The phone number is already exists.',
            'phoneNo.regex' => 'The phone number must contain only digits (no special characters).',
            'agencyId.required' => 'The agency ID field is required.',
            'isVirtual.required' => 'The is virtual field is required.',
            'isPhysical.required' => 'The is physical field is required.',
            'canCreateCase.required' => 'The can create case field is required.',
            'hasFco.required' => 'The has FCO field is required.',
            'hasCounsellor.required' => 'The has counsellor field is required.',
        ];
    }
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}
