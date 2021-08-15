<?php

namespace App\Http\Requests\User;

use Pearl\RequestValidate\RequestAbstract;

class UserStoreRequest extends RequestAbstract
{
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
            'name'     =>   'required|string|max:255',
            'cpf'      =>   'required|cpf|unique:users',
            'email'    =>   'required|email|unique:users',
            'type'     =>   'required|',
            'password' =>   'required|confirmed|min:8',
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
            //
        ];
    }
}
