<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class CongDanRequest extends FormRequest
{
    private $table = 'cong_dans';

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
        $cccdImageFront = $this->cccd_image_front;
        $cccdImageRear = $this->cccd_image_rear;

        $ruleSelectStatus = array_keys(Config::get('custom.enum.selectStatus'));
        $ruleSelectGender = array_keys(Config::get('custom.enum.gender'));

        $condFullname = '';
        $condGender  = '';
        $condDob  = '';
        $condAddress  = '';
        $condPhone  = '';
        $condStatus   = '';

        $condCccdNumber  = '';
        $condCccdDos  = '';
        $condAvatar   = '';
        $condCccdImageFront   = '';
        $condCccdImageRear  = '';

        switch ($task) {
            case 'add':
                $condFullname       = ['bail','required','between:5,100'];
                $condCccdNumber     = ['bail','required','between:5,20',Rule::unique($this->table,'cccd_number')];
                $condCccdDos        = ['bail','required','date'];

                $condGender         = ['bail',Rule::in($ruleSelectGender)];
                $condDob            = ['bail','required','date'];
                $condAddress        = ['bail','required','between:5,200'];

                $condPhone          = ['bail','required','between:10,20',Rule::unique($this->table,'phone')];
                $condStatus         = ['bail',Rule::in($ruleSelectStatus)];

                $condAvatar         = ['bail','required','image','mimes:jpeg,png,jpg,gif','max:5000'];
                $condCccdImageFront = ['bail','required','image','mimes:jpeg,png,jpg,gif','max:5000'];
                $condCccdImageRear  = ['bail','required','image','mimes:jpeg,png,jpg,gif','max:5000'];
                break;

            case 'edit':
                $condFullname       = ['bail','required','between:5,100'];
                $condCccdNumber     = ['bail','required','between:5,20',Rule::unique($this->table,'cccd_number')->ignore($id)];
                $condCccdDos        = ['bail','required','date'];

                $condGender         = ['bail',Rule::in($ruleSelectGender)];
                $condDob            = ['bail','required','date'];
                $condAddress        = ['bail','required','between:5,200'];

                $condPhone          = ['bail','required','between:10,20',Rule::unique($this->table,'phone')->ignore($id)];
                $condStatus         = ['bail',Rule::in($ruleSelectStatus)];

                $condAvatar         = ($avatar) ? ['bail','image','mimes:jpeg,png,jpg,gif','max:5000'] : '';
                $condCccdImageFront = ($cccdImageFront) ? ['bail','image','mimes:jpeg,png,jpg,gif','max:5000'] : '';
                $condCccdImageRear  = ($cccdImageRear) ? ['bail','image','mimes:jpeg,png,jpg,gif','max:5000'] : '';
                break;

            default:
                break;
        }


        return [
            'fullname' => $condFullname,
            'cccd_number' => $condCccdNumber,
            'cccd_dos' => $condCccdDos,

            'gender' => $condGender,
            'dob' => $condDob,
            'address' => $condAddress,

            'phone' => $condPhone,
            'status' => $condStatus ,

            'avatar' => $condAvatar ,
            'cccd_image_front' => $condCccdImageFront ,
            'cccd_image_rear' => $condCccdImageRear
        ];
        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $requiredMsg = ':attribute không được để trống';
        $betweenMsg = ':attribute (:input) không phù hợp, vui lòng nhập :min - :max ký tự';
        $uniqueMsg = ':attribute (:input) đã được sử dụng, vui lòng nhập :attribute khác';
        $inMsg = ':attribute (:input) không đúng, vui lòng chọn lại';
        $wrongFormatMsg = ':attribute không đúng định dạng';
        $limitSizeFileMsg = ':attribute không được lớn hơn 5MB';

        return [
            'fullname.required' => $requiredMsg,
            'fullname.between'  => $betweenMsg,

            'cccd_number.required'  => $requiredMsg,
            'cccd_number.between'   => $betweenMsg,
            'cccd_number.unique'    => $uniqueMsg,

            'cccd_dos.required' => $requiredMsg,
            'cccd_dos.date'     => $wrongFormatMsg,

            'gender.in' => $inMsg,

            'dob.required'  => $requiredMsg,
            'dob.date'      => $wrongFormatMsg,

            'address.required'  => $requiredMsg,
            'address.between'   => $betweenMsg,

            'phone.required'    => $requiredMsg,
            'phone.between'     => $betweenMsg,
            'phone.unique'      => $uniqueMsg,

            'status.in' => $inMsg,

            'avatar.required'   => $requiredMsg,
            'avatar.max'        => $limitSizeFileMsg,

            'cccd_image_front.required' => $requiredMsg,
            'cccd_image_front.max'      => $limitSizeFileMsg,

            'cccd_image_rear.required'  => $requiredMsg,
            'cccd_image_rear.max'       => $limitSizeFileMsg
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
            'fullname' => 'Họ Tên',
            'cccd_number' => 'Số CCCD',
            'cccd_dos' => 'Ngày Cấp CCCD',
            'gender' => 'Giới Tính',
            'dob' => 'Ngày Sinh',
            'address' => 'Địa Chỉ Thường Trú',
            'phone' => 'Số Điện Thoại',
            'status' => 'Trạng Thái',
            'avatar' => 'Ảnh Đại Diện',
            'cccd_image_front' => 'Ảnh Mặt Trước CCCD',
            'cccd_image_rear' => 'Ảnh Mặt Sau CCCD',
        ];
    }
}
