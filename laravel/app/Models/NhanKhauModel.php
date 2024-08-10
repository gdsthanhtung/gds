<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NhanKhauModel extends Model
{
    use HasFactory;
    protected $table = 'nhan_khaus';
    protected $uploadDir = 'nhan_khau';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $tableUser = 'users';
    protected $tablePhongTro = 'phong_tros';
    protected $tableCongDan = 'cong_dans';

    protected $crudNotAccepted = ['_token', 'cong_dan_list', 'mqh_list', 'id'];

    public function save($params = null, $options = null){
        $result = null;
        $id = (isset($params['id'])) ? $params['id'] : null;
        $loginUserId = Session::get('userInfo')['id'];
        $params['modified'] = Carbon::now();

        $rsDeleteOldData = Self::where('hop_dong_id', $params['hop_dong_id'])->delete();

        $mqh = explode(",", $params['mqh_id']);
        $congDan = explode(",", $params['cong_dan_id']);

        dd($params, $rsDeleteOldData, $mqh, $congDan);


        // if($options['task'] == 'add' || $options['task'] == 'edit'){
        //     $params['thue_tu_ngay'] = Carbon::parse( $params['thue_tu_ngay'])->format('Y-m-d');
        //     $params['thue_den_ngay'] = Carbon::parse( $params['thue_den_ngay'])->format('Y-m-d');
        // }

        // if($options['task'] == 'add'){
        //     $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));
        //     $paramsNew['created'] = Carbon::now();
        //     $paramsNew['created_by'] = $paramsNew['modified_by'] = $loginUserId;
        //     $result = Self::insert($paramsNew);
        // }

        return $result;
    }
}
