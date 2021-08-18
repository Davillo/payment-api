<?php

namespace App\Http\Requests\Transaction;

use Pearl\RequestValidate\RequestAbstract;

class TransactionStoreRequest extends RequestAbstract
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
            'value'    => 'required|numeric',
            'payee_id' => 'required|integer|exists:users,id,deleted_at,NULL',
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
            'value.required' => 'Value is required',
            'value.numeric' => 'Value needs to be a numeric value',
            'payee_id.required' => 'The payee id is required',
            'payee_id.integer'  => 'The payee id needs to be a integer value',
            'payee_id.exists'  => 'The payee id needs to be a valid user',
        ];
    }
}
