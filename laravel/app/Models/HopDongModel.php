<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

    protected $crudNotAccepted = ['_token'];

    public function listItems($params = null, $options = null){
        $this->table = $this->table.' as main';
        $result = null;
        $perPage = $params["pagination"]['perPage'];

        $filterStatus   = $params['filter']['status'];
        $searchField    = $params['filter']['searchField'];
        $searchValue    = $params["filter"]['searchValue'];
        $fieldAccepted  = $params["filter"]['fieldAccepted'];

        if($options['task'] == 'admin-list-items'){
            $query = Self::select(DB::raw('main.*, pt.name as pt_name, cd.avatar as cd_avatar, cd.fullname as cd_fullname, cd.cccd_number as cd_cccd_number, cd.status as cd_status, c_user.fullname as created_by_name, u_user.fullname as modified_by_name'));
            if($searchValue)
                if($searchField == 'all'){
                    $query->where(function($query) use ($fieldAccepted, $searchValue){
                        foreach($fieldAccepted as $field){
                            if($field != 'all') $query->orWhere('main.'.$field, 'LIKE', "%$searchValue%");
                        }
                    });
                }else{
                    $query->where('main.'.$searchField, 'LIKE', "%$searchValue%");
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

    public function countItems($params = null, $options = null){
        $result = null;

        $searchField    = $params['filter']['searchField'];
        $searchValue    = $params["filter"]['searchValue'];
        $fieldAccepted  = $params["filter"]['fieldAccepted'];

        if($options['task'] == 'admin-count-items'){
            $query = Self::selectRaw('count(id) as total, status');
            if($searchValue)
                if($searchField == 'all'){
                    $query->where(function($query) use ($fieldAccepted, $searchValue){
                        foreach($fieldAccepted as $field){
                            if($field != 'all') $query->orWhere($field, 'LIKE', "%$searchValue%");
                        }
                    });
                }else{
                    $query->where($searchField, 'LIKE', "%$searchValue%");
                }
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
