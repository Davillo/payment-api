<?php

namespace App\Http\Requests\User;

use Pearl\RequestValidate\RequestAbstract;

class AuthenticationStoreRequest extends RequestAbstract
{
    private const DEFAULT_AUTHENTICATION_MESSAGE = 'E-mail ou senha inválidos';

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
            'email.required'    => self::DEFAULT_AUTHENTICATION_MESSAGE,
            'password.required' => self::DEFAULT_AUTHENTICATION_MESSAGE,
            'email.exists'      => self::DEFAULT_AUTHENTICATION_MESSAGE
        ];
    }
}
