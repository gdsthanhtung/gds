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

    protected $tableCongDan = 'cong_dans';

    protected $crudNotAccepted = ['_token', 'cong_dan_list', 'mqh_list', 'id'];

    public function save($params = null, $options = null){
        $result = null;
        $hopDongId = (isset($params['hop_dong_id'])) ? $params['hop_dong_id'] : null;
        $loginUserId = Session::get('userInfo')['id'];
        $params['modified'] = Carbon::now();

        if(!$hopDongId) return false;

        $mqhs = explode(",", $params['mqh_id']);
        $congDans = explode(",", $params['cong_dan_id']);

        $insertData = [];
        foreach($congDans as $key => $congDan){
            $item = [
                'hop_dong_id'   => $hopDongId,
                'cong_dan_id'   => $congDan,
                'mqh_chu_phong' => $mqhs[$key],
                'hop_dong_id'   => $hopDongId,
                'created_by'    => $loginUserId,
                'modified_by'   => $loginUserId,
                'created'       => Carbon::now(),
                'modified'      => Carbon::now(),
            ];
            $insertData[] = $item;
        }

        $rsDeleteOldData = Self::where('hop_dong_id', $params['hop_dong_id'])->delete();
        $result = Self::insert($insertData);

        return true;
    }
}
