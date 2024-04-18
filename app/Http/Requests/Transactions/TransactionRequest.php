<?php

namespace App\Http\Requests\Transactions;

use App\Constants\ResponseMessages;
use App\Http\Requests\Party\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'financial_categories_id' => 'required',
            'value' => 'required',
            'financial_id' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Item is required',
            'description.required' => 'Item is required',
            'financial_categories_id.required' => 'Item is required',
            'value.required' => 'Item is required',
            'financial_id.required' => 'Item is required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => $validator->errors(),
            'message' => ResponseMessages::NOT_AUTHORIZED
        ], 422));
    }

}
