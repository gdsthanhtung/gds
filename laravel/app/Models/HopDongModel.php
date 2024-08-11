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

    protected $crudNotAccepted = ['_token'];

    public function listItems($params = null, $options = null){
        $table = $this->table.' as main';
        $result = null;
        $perPage = $params["pagination"]['perPage'];

        $filterStatus   = $params['filter']['status'];
        $searchField    = $params['filter']['searchField'];
        $searchValue    = $params["filter"]['searchValue'];
        $fieldAccepted  = $params["filter"]['fieldAccepted'];

        if($options['task'] == 'admin-list-items'){
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
        $query->select(DB::raw('nk.id, nk.hop_dong_id, nk.cong_dan_id, cd.fullname, cd.cccd_number, cd.status, cd.avatar, cd.dob, cd.cccd_dos, cd.gender'));
        $query->whereIn('nk.hop_dong_id', $hopDongIds);
        $query->leftJoin($tableCongDan, 'nk.cong_dan_id', '=', 'cd.id');
        $result = $query->orderBy('cd.fullname', 'asc')->get()->toArray();

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
        return $result;
    }
}
