<?php

namespace App\Http\Requests\User;

use Pearl\RequestValidate\RequestAbstract;

class AuthenticationStoreRequest extends RequestAbstract
{
    private const DEFAULT_AUTHENTICATION_MESSAGE = 'Invalid email or password';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'The email are required',
            'email.email'       => 'The email are invalid',
            'password.required' => 'The password are required',
            'email.exists'      => self::DEFAULT_AUTHENTICATION_MESSAGE
        ];
    }
}
