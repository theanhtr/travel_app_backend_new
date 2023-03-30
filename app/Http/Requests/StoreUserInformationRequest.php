<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreUserInformationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'numeric|unique:user_information',
            'date_of_birth' => 'date',
            'email_contact' => 'email|unique:user_information',
            'email' => 'required|email'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 400));
    }

    public function messages()
    {
        return [
            'first_name.string' => 'First name is wrong type',
            'last_name.string' => 'Last name is wrong type',
            'last_name.required' => 'Last name is required',
            'first_name.required' => 'First name is required',
            'email.required' => 'Email user is required',
            'email.email' => 'Email user is wrong type',
            'phone_number.numeric' => 'Phone number is wrong type',
            'date_of_birth.date' => 'Date of birth is wrong type',
            'email_contact.email' => 'Email contact is wrong type',
            'email_contact.unique' => 'Email contact is exists',
            'phone_number.unique' => 'Phone number is exists',
        ];
    }
}
