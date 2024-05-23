<?php

namespace App\Http\Requests;

use App\Models\Charge;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ChargeRequest extends FormRequest
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

        $charge = $this->route()->parameter('charge');

        $rules = [
            'amount' => 'required',
            'type' => 'required|in:1,2',
            'date' => 'required|date_format:Y-m-d',
            'status' => 'required|numeric'
        ];

        if (request("type") == Charge::NORMAL) {
            $rules = array_merge($rules, [
                'chargeable_id' => 'required',
                'chargeable_type' => 'required',
                'description' => "required|max:255"
            ]);
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
