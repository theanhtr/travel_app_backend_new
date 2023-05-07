<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserInformationRequest extends FormRequest
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
                'email' => 'required|email',
                'first_name' => 'string',
                'last_name' => 'string',
                'phone_number' => 'numeric|unique:user_information',
                'date_of_birth' => 'date',
                'email_contact' => 'email|unique:user_information'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Invalid input parameter structure',
            'data'      => $validator->errors()
        ], 422));
    }
}
