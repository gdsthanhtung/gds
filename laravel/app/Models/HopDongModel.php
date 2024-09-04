<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\CongDanModel;

class HopDongModel extends Model
{
    use HasFactory;
    protected $table = 'hop_dongs';
    protected $uploadDir = 'hop_dong';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $tableUser = 'users';
    protected $tablePhongTro = 'phong_tros';
    protected $tableCongDan = 'cong_dans';
    protected $tableNhanKhau = 'nhan_khaus';

    protected $crudNotAccepted = ['_token', 'task'];

    public function listItems($params = null, $options = null){
        $table = $this->table.' as main';
        $result = null;

        if($options['task'] == 'admin-list-items'){
            $perPage = $params["pagination"]['perPage'];

            $filterStatus   = $params['filter']['status'];
            $searchField    = $params['filter']['searchField'];
            $searchValue    = $params["filter"]['searchValue'];
            $fieldAccepted  = $params["filter"]['fieldAccepted'];

            $query = Self::from($table);
            $query->select(DB::raw('main.*, pt.name as pt_name, cd.avatar as cd_avatar, cd.fullname as cd_fullname, cd.cccd_number as cd_cccd_number, cd.status as cd_status, c_user.fullname as created_by_name, u_user.fullname as modified_by_name'));
            if($searchValue)
            if($searchField == 'all'){
                unset($fieldAccepted[0]);
                $query->whereAny($fieldAccepted, 'LIKE', "%$searchValue%");
            }else{
                $query->where($searchField, 'LIKE', "%$searchValue%");
            }

            if($filterStatus != 'all'){
                $query->where('main.status', $filterStatus);
            }
            $query->leftJoin($this->tablePhongTro.' as pt', 'pt.id', '=', 'main.phong_id');
            $query->leftJoin($this->tableCongDan.' as cd', 'cd.id', '=', 'main.cong_dan_id');
            $query->leftJoin($this->tableUser.' as c_user', 'c_user.id', '=', 'main.created_by');
            $query->leftJoin($this->tableUser.' as u_user', 'u_user.id', '=', 'main.modified_by');
            $result = $query->orderBy('main.id', 'desc')->paginate($perPage);
        }

        if($options['task'] == 'admin-list-items-for-select'){
            $query = Self::from($table);
            $query->select(DB::raw('main.*, pt.name as pt_name, cd.avatar as cd_avatar, cd.fullname as cd_fullname, cd.cccd_number as cd_cccd_number,
                                    cd.status as cd_status, cd.is_city, c_user.fullname as created_by_name, u_user.fullname as modified_by_name,
                                    is_city_0, is_city_1'));

            $query->where('main.status', 'active');

            $query->leftJoin($this->tablePhongTro.' as pt', 'pt.id', '=', 'main.phong_id');
            $query->leftJoin($this->tableCongDan.' as cd', 'cd.id', '=', 'main.cong_dan_id');
            $query->leftJoin($this->tableUser.' as c_user', 'c_user.id', '=', 'main.created_by');
            $query->leftJoin($this->tableUser.' as u_user', 'u_user.id', '=', 'main.modified_by');
            $query->leftJoin(DB::raw('
                    (SELECT nk.hop_dong_id, COUNT(cd.is_city) as count_is_city,
                    COUNT(IF(cd.is_city = 1, cd.is_city, NULL)) AS is_city_1,
                    COUNT(IF(cd.is_city = 0, cd.is_city, NULL)) AS is_city_0
                    FROM nhan_khaus as nk
                    LEFT JOIN cong_dans as cd ON cd.id = nk.cong_dan_id
                    WHERE cd.status = "active"
                    GROUP BY nk.hop_dong_id
                    ORDER BY  nk.hop_dong_id)
                 AS nk_city'), 'nk_city.hop_dong_id', '=', 'main.id');
            $result = $query->orderBy('main.id', 'desc')->get()->toArray();
        }

        return $result;
    }

    public function assignNK($listHopDong = []){
        if(!$listHopDong) return [];

        $hopDongIds = [];
        $hopDongIds = array_map(function($listHopDong) {
            return $listHopDong['id'];
        }, $listHopDong);

        if(!$hopDongIds) return [];

        $tableNhanKhau = $this->tableNhanKhau.' as nk';
        $tableCongDan = $this->tableCongDan.' as cd';

        $query = Self::from($tableNhanKhau);
        $query->select(DB::raw('nk.id, nk.hop_dong_id, nk.cong_dan_id, nk.mqh_chu_phong, cd.fullname, cd.cccd_number, cd.status, cd.avatar, cd.dob, cd.cccd_dos, cd.gender'));
        $query->whereIn('nk.hop_dong_id', $hopDongIds);
        $query->leftJoin($tableCongDan, 'nk.cong_dan_id', '=', 'cd.id');
        $result = $query->orderBy('nk.mqh_chu_phong', 'asc')->get()->toArray();

        $rsGroup = [];
        if($result) foreach($result as $key => $item){
            $rsGroup[$item['hop_dong_id']][] = $item;
        }

        return $rsGroup;
    }

    public function countItems($params = null, $options = null){
        $result = null;
        $table = $this->table.' as main';

        $searchField    = $params['filter']['searchField'];
        $searchValue    = $params["filter"]['searchValue'];
        $fieldAccepted  = $params["filter"]['fieldAccepted'];

        if($options['task'] == 'admin-count-items'){
            $query = Self::from($table);
            $query->selectRaw('count(main.id) as total, main.status');
            if($searchValue)
                if($searchField == 'all'){
                    unset($fieldAccepted[0]);
                    $query->whereAny($fieldAccepted, 'LIKE', "%$searchValue%");
                }else{
                    $query->where($searchField, 'LIKE', "%$searchValue%");
                }
            $query->leftJoin($this->tablePhongTro.' as pt', 'pt.id', '=', 'main.phong_id');
            $query->leftJoin($this->tableCongDan.' as cd', 'cd.id', '=', 'main.cong_dan_id');
            $result = $query->groupBy('status')->get()->toArray();
        }

        return $result;
    }

    public function delete($params = null){
        $result = null;
        $result = Self::where('id', $params['id'])->delete();
        return $result;
    }

    public function saveItem($params = null, $options = null){
        $result = null;
        $id = (isset($params['id'])) ? $params['id'] : null;
        $loginUserId = Session::get('userInfo')['id'];
        $params['modified'] = Carbon::now();

        if($options['task'] == 'change-status'){
            $paramsNew = $params;
            $paramsNew['status'] = ($params['status'] == 'active') ? 'inactive' : 'active';
            $paramsNew['modified_by'] = $loginUserId;
            $result = Self::where('id', $id)->update($paramsNew);
        }

        if($options['task'] == 'add' || $options['task'] == 'edit'){
            $params['thue_tu_ngay'] = Carbon::parse( $params['thue_tu_ngay'])->format('Y-m-d');
            $params['thue_den_ngay'] = Carbon::parse( $params['thue_den_ngay'])->format('Y-m-d');
        }

        if($options['task'] == 'add'){
            $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));
            $paramsNew['ma_hop_dong'] = Carbon::now()->format('YmdHi');
            $paramsNew['created'] = Carbon::now();
            $paramsNew['created_by'] = $paramsNew['modified_by'] = $loginUserId;
            $result = Self::insert($paramsNew);
        }

        if($options['task'] == 'edit'){
            $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));
            $paramsNew['modified_by'] = $loginUserId;
            $result = Self::where('id', $id)->update($paramsNew);
        }

        return $result;
    }

    public function getItem($params = null, $options = null){
        $result = null;
        if($options['task'] == 'get-item'){
            $result = Self::select('*')->where('id', $params['id'])->first();
        }
        if($options['task'] == 'get-item-with-chu-ho'){
            $table = $this->table.' as main';
            $query = Self::from($table);
            $query->select(DB::raw('main.*, cd.avatar as cd_avatar, cd.fullname as cd_fullname, cd.address as cd_address, cd.cccd_number as cd_cccd_number, cd.cccd_dos as cd_cccd_dos, cd.status as cd_status'));
            $query->where('main.id', $params['id']);
            $query->leftJoin($this->tableCongDan.' as cd', 'cd.id', '=', 'main.cong_dan_id');
            $result = $query->first();
        }
        return $result;
    }
}
