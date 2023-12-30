<?php

namespace App\Http\Requests;

use App\Models\Network;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $network_id = Auth::user()["network_id"];
        $network = Network::where("id", $network_id)->first();
        if(!$network || !$network["status"]){
            return false;
        }
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
            "name" => ["required", "min:3", "max:25"],
            "username" => ["required", "min:3", "max:25", "exists:users"],
            "password" => ["required", "min:3", "max:25"],
            "email" => ["optional", "email"],
            "phone" => ["required", "digits:10", "numeric"],
            "role_id" => ["required", "exists:user_roles,id"]
        ];
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json(["errors" => $validator->errors()], 422));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json(["message" => "You're Not Authorised"], 401));
    }
}
