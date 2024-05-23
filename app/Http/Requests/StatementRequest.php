<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StatementRequest extends FormRequest
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

        $update = request()->routeIs('statements.update');
        $rules = [
            'client_id' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d|statement_create_month_unique',
            'type' => 'required|numeric',
            'status' => 'required|in:1,2',
        ];

        if ($update) {
            $rules["date"] = 'required|date_format:Y-m-d|statement_update_month_unique';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'statement_create_month_unique' => 'Solo se puede registrar un estado de cuenta por mes.',
            'statement_update_month_unique'=>'No puede cambiar el mes del estado de cuenta.',

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
