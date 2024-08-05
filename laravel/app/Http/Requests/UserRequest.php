<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class UserRequest extends FormRequest
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
        $id = $this->id;
        $task = $this->task;
        $avatar = $this->avatar;

        $ruleSelectStatus = array_keys(Config::get('custom.enum.selectStatus'));
        $ruleSelectLevel = array_keys(Config::get('custom.enum.selectLevel'));

        $condAvatar   = '';
        $condUsername = '';
        $condEmail    = '';
        $condPass     = '';
        $condLevel    = '';
        $condStatus   = '';
        $condFullname = '';

        switch ($task) {
            case 'add':
                $condUsername   = ['bail','required','between:5,100',Rule::unique($this->table,'username')];
                $condEmail      = ['bail','required','email',Rule::unique($this->table,'email')];
                $condFullname   = ['bail','required','min:5'];
                $condPass       = ['bail','required','between:5,100','confirmed'];
                $condStatus     = ['bail',Rule::in($ruleSelectStatus)];
                $condLevel      = ['bail',Rule::in($ruleSelectLevel)];
                $condAvatar     = ['bail','required','image','max:500'];
                break;

            case 'edit':
                $condUsername   = ['bail','required','between:5,100',Rule::unique($this->table, 'username')->ignore($id)];
                $condFullname   = ['bail','required','min:5'];
                $condAvatar     = ($avatar) ? ['bail','image','max:500'] : '';
                $condStatus     = ['bail',Rule::in($ruleSelectStatus)];
                $condLevel      = ['bail',Rule::in($ruleSelectLevel)];
                $condEmail      = ['bail','required','email',Rule::unique($this->table,'email')->ignore($id)];
                break;

            case 'change-password':
                $condPass       = ['bail','required','between:5,100','confirmed'];
                break;

            default:
                break;
        }


        return [
            'username' => $condUsername,
            'email'    => $condEmail,
            'fullname' => $condFullname,
            'status'   => $condStatus,
            'password' => $condPass,
            'level'    => $condLevel,
            'avatar'   => $condAvatar
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
            'username.required' => 'Tên không được để trống',
            'fullname.required' => 'Tên không được để trống',
            'email.required'    => 'Mô tả không được để trống',
            'password.required' => 'Password không được để trống',
            'avatar.required'   => 'Avatar không được để trống',

            'username.between'  => 'Username (:input) không phù hợp, vui lòng nhập :min - :max ký tự',
            'fullname.min'      => 'Fullname (:input) không phù hợp, vui lòng nhập ít nhất :min ký tự',
            'email.min'         => 'Email (:input) không phù hợp, vui lòng nhập ít nhất :min ký tự',
            'password.min'      => 'Password (:input) không phù hợp, vui lòng nhập ít nhất :min ký tự',

            'email.email'       => 'Email (:input) không đúng định dạng, vui lòng nhập lại',
            'email.unique'      => 'Email (:input) đã được sử dụng, vui lòng nhập :attribute khác',

            'status.in'         => 'Status (:input) không đúng, vui lòng chọn lại',
            'level.in'          => 'Level (:input) không đúng, vui lòng chọn lại',
            'password.confirmed'=> 'Password lặp lại không khớp'
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
