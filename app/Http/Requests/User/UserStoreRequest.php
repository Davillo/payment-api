<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\NationalRegistryRule;
use Illuminate\Validation\Rule;
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
            'name'                   =>   'required|string|max:255',
            'national_registry'      =>   ['required', 'string', 'unique:users', new NationalRegistryRule],
            'email'                  =>   'required|email|unique:users',
            'type'                   =>   ['required', 'string', Rule::in(
                [
                    User::USER_TYPE_CUSTOMER,
                    User::USER_TYPE_SHOPKEEPER,
                    User::USER_TYPE_ADMIN])
                ],
            'password'               =>   'required|confirmed|min:8',
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
