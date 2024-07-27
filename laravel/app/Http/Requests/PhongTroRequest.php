<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class PhongTroRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //bail => gap loi nao la return luon, khong can validate tat ca
        return [
            'name'          => ['bail', 'required', 'min:5'],
            'status'        => ['bail', Rule::in(array_keys(Config::get('custom.enum.selectStatus')))]
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
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên (:input) không phù hợp, vui lòng nhập ít nhất :min ký tự',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    // public function attributes(): array
    // {
    //     return [
    //         'name' => 'Tên',
    //     ];
    // }
}
