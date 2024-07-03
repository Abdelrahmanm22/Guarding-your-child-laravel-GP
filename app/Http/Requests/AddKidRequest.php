<?php

namespace App\Http\Requests;

use App\Trait\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class AddKidRequest extends FormRequest
{
    use ApiResponseTrait;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image'=>'required|file|mimes:jpeg,png,jpg,bmp',
            'SSN' => 'required|unique:kids,SSN',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'gender' => 'required|in:male,female',
            'birthDate' => 'required|date',
            'SSN_father'=>'required',
            'father_name'=>'required|max:50',
            'SSN_mother'=>'required',
            'mother_name'=>'required|max:50',
            'address'=>'required|max:200',
            'phone'=>'required',
            'bloodType' => 'required|in:O-,O+,A-,A+,B-,B+,AB-,AB+'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->apiResponse(null, $validator->errors(), 400)
        );
    }
}
