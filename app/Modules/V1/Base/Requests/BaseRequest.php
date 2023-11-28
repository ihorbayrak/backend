<?php

namespace App\Modules\V1\Base\Requests;

use App\Modules\V1\Base\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    abstract public function rules(): array;

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator->errors()->getMessages());
    }
}
