<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class AuthRequest extends FormRequest
{
    private $table = 'users';

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
        $task = $this->task;

        $condEmail    = '';
        $condPass     = '';

        switch ($task) {
            case 'do-login':
                $condEmail      = ['bail','required','email'];
                $condPass       = ['bail','required'];
                break;

            default:
                break;
        }

        return [
            'email'    => $condEmail,
            'password' => $condPass,
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
            'email.required'    => 'Mô tả không được để trống',
            'password.required' => 'Password không được để trống',
            'email.email'       => 'Email (:input) không đúng định dạng'
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
