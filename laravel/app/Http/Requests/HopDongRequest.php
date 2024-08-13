<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class HopDongRequest extends FormRequest
{
    private $table = 'hop_dongs';
    private $tablePhongTro = 'phong_tros';
    private $tableCongDan = 'cong_dans';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->id;
        $task = $this->task;

        $ruleSelectStatus = array_keys(Config::get('custom.enum.selectStatus'));
        $ruleSelectYesNo  = array_keys(Config::get('custom.enum.selectYesNo'));

        return [
            'cong_dan_id'           => ['bail','required',Rule::exists($this->tableCongDan,'id')],
            'phong_id'              => ['bail','required',Rule::exists($this->tablePhongTro,'id')],
            'thue_tu_ngay'          => ['bail','required','date'],
            'thue_den_ngay'         => ['bail','required','date'],
            'gia_phong'             => ['bail','required','integer'],
            'chi_so_dien'           => ['bail','required','integer'],
            'chi_so_nuoc'           => ['bail','required','integer'],
            'huong_dinh_muc_dien'   => ['bail',Rule::in($ruleSelectYesNo)],
            'huong_dinh_muc_nuoc'   => ['bail',Rule::in($ruleSelectYesNo)],
            'status'                => ['bail',Rule::in($ruleSelectStatus)],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $requiredMsg        = ':attribute không được để trống';
        $betweenMsg         = ':attribute (:input) không phù hợp, vui lòng nhập :min - :max ký tự';
        $uniqueMsg          = ':attribute (:input) đã được sử dụng, vui lòng nhập :attribute khác';
        $inMsg              = ':attribute (:input) không đúng, vui lòng chọn lại';
        $wrongFormatMsg     = ':attribute không đúng định dạng';
        $limitSizeFileMsg   = ':attribute không được lớn hơn 5MB';
        $existMsg           = ':attribute không tồn tại';

        return [
            'cong_dan_id.required'  => $requiredMsg,
            'cong_dan_id.exists'     => $existMsg,

            'phong_id.required'  => $requiredMsg,
            'phong_id.exists'     => $existMsg,

            'thue_tu_ngay.required'  => $requiredMsg,
            'thue_tu_ngay.date'  => $wrongFormatMsg,

            'thue_den_ngay.required'  => $requiredMsg,
            'thue_den_ngay.date'  => $wrongFormatMsg,

            'gia_phong.required'  => $requiredMsg,
            'gia_phong.number'  => $wrongFormatMsg,

            'chi_so_dien.required'  => $requiredMsg,
            'chi_so_dien.number'  => $wrongFormatMsg,

            'chi_so_nuoc.required'  => $requiredMsg,
            'chi_so_nuoc.number'  => $wrongFormatMsg,

            'huong_dinh_muc_dien.required'  => $requiredMsg,
            'huong_dinh_muc_dien.between'  => $wrongFormatMsg,

            'huong_dinh_muc_nuoc.required'  => $requiredMsg,
            'huong_dinh_muc_nuoc.between'  => $wrongFormatMsg,

            'status.required'  => $requiredMsg,

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
            'cong_dan_id'           => 'Công dân Id',
            'phong_id'              => 'Phòng Id',
            'thue_tu_ngay'          => 'Thuê từ ngày',
            'thue_den_ngay'         => 'Thuê đến ngày',
            'gia_phong'             => 'Giá phòng',
            'chi_so_dien'           => 'Chỉ số điện',
            'chi_so_nuoc'           => 'Chỉ số nước',
            'huong_dinh_muc_dien'   => 'Hưởng định mức điện',
            'huong_dinh_muc_nuoc'   => 'Hưởng định mức nước',
            'status'                => 'Trạng Thái',
        ];
    }
}
