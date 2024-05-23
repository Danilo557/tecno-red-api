<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class InvoiceProductRequest extends FormRequest
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

        $update = request()->routeIs('edit.invoices.products');
        $rules = [
            'invoice_id' => 'required|invoice_product_unique|numeric',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'amount' => 'required',

        ];

        if ($update) {
            $rules["invoice_id"] = "required";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'invoice_product_unique' => 'No puede agregar el mismo producto más de una vez.',

        ];
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
