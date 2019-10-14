<?php

namespace Takaworx\Brix\Http\Requests;

use Takaworx\Brix\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class BaseFormRequest extends FormRequest
{
    /**
     * Override the default failed validation handler
     *
     * @param Illuminate\Contracts\Validation\Validator $validator
     */
    final protected function failedValidation(Validator $validator)
    {
        $errors   = $validator->errors();
        $response = ApiResponse::badRequest($errors);
        throw new HttpResponseException($response);
    }
}
