<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $store = $this->route()->parameter('store');
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:stores',

        ];

        if ($store) {
            $rules['slug'] = 'required|max:255|unique:stores,slug,' . $store->id;
        }

        return $rules;
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                [
                    'status' => 'fail',
                    'code' => 400,
                    'errors' => $errors
                ],
                JsonResponse::HTTP_OK
            )
        );
    }
}
