<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NhanKhauRequest extends FormRequest
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
        return [
            'cd_id' => ['bail', 'required'],
            'mqh_id' => ['bail', 'required'],
            'hop_dong_id' => ['bail', 'required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $requiredMsg = ':attribute không được để trống';
        return [
            'cd_id.required' => $requiredMsg,
            'mqh_id.required' => $requiredMsg,
            'hop_dong_id.required' => $requiredMsg
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'cd_id' => 'Thông tin công dân',
            'mqh_id' => 'Mối quan hệ với chủ hộ',
            'hop_dong_id' => 'Hợp đồng',
        ];
    }
}
