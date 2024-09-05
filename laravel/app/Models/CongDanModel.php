<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Resource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Config;

class CongDanModel extends Model
{
    use HasFactory;
    protected $table = 'cong_dans';
    protected $uploadDir = 'congdan';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $crudNotAccepted = ['_token', 'avatar', 'avatar_current', 'cccd_image_front', 'cccd_image_front_current', 'cccd_image_rear', 'cccd_image_rear_current', 'password_confirmation', 'task'];

    public function listItems($params = null, $options = null){
        $this->table = $this->table.' as main';
        $result = null;

        if($options['task'] == 'admin-list-items'){
            $perPage = $params["pagination"]['perPage'];
            $filterStatus   = $params['filter']['status'];
            $searchField    = $params['filter']['searchField'];
            $searchValue    = $params["filter"]['searchValue'];
            $fieldAccepted  = $params["filter"]['fieldAccepted'];

            $query = Self::select(DB::raw('main.*, c_user.fullname as created_by_name, u_user.fullname as modified_by_name'));
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
            $query->leftJoin('users as c_user', 'c_user.id', '=', 'main.created_by');
            $query->leftJoin('users as u_user', 'u_user.id', '=', 'main.modified_by');
            $result = $query->orderBy('main.id', 'desc')->paginate($perPage);
        }

        if($options['task'] == 'admin-list-items-to-select'){
            $query = Self::select(DB::raw('main.id, CONCAT_WS(" - ",main.fullname, main.cccd_number, main.status) as info'));
            $result = $query->orderBy('main.fullname', 'asc')->pluck('info', 'id')->toArray();
        }

        if($options['task'] == 'admin-list-items-expired-dktt'){
            $query = Self::select(DB::raw('main.*'));
            $query->where('main.dktt_den_ngay', '<', Carbon::now()->addMonth(1)->format('Y-m-d'));
            $query->where('main.status', '=', 'active');
            $result = $query->orderBy('main.fullname', 'asc')->get()->toArray();
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
        $item = Self::getItem($params, ['task' => 'get-item']);
        $result = Self::where('id', $params['id'])->delete();

        if($result) Resource::delete($this->uploadDir, $item['avatar']);
        return $result;
    }

    public function saveItem($params = null, $options = null){
        $result = null;
        $id = (isset($params['id'])) ? $params['id'] : null;
        $loginUserId = Session::get('userInfo')['id'];
        $params['modified'] = Carbon::now();
        $typeImages = ['avatar','cccd_image_front','cccd_image_rear'];

        if($options['task'] == 'change-status'){
            $paramsNew = $params;
            $paramsNew['status'] = ($params['status'] == 'active') ? 'inactive' : 'active';
            $paramsNew['modified_by'] = $loginUserId;
            $result = Self::where('id', $id)->update($paramsNew);
        }

        if($options['task'] == 'add' || $options['task'] == 'edit'){
            $params['dktt_tu_ngay'] = Carbon::parse( $params['dktt_tu_ngay'])->format('Y-m-d');
            $params['dktt_den_ngay'] = Carbon::parse( $params['dktt_den_ngay'])->format('Y-m-d');
            $params['fullname'] = mb_strtoupper($params['fullname'], "UTF-8");
        }

        if($options['task'] == 'add'){
            $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));
            $paramsNew['created'] = Carbon::now();
            $paramsNew['created_by'] = $paramsNew['modified_by'] = $loginUserId;
            $paramsNew['dob'] = Carbon::parse($paramsNew['dob'])->format('Y-m-d');
            $paramsNew['cccd_dos'] = Carbon::parse($paramsNew['cccd_dos'])->format('Y-m-d');

            foreach($typeImages as $type){
                $rsUpload = $this->processImage($type, $params, $paramsNew, $delOldImage = false);
                if($rsUpload['status'] == false) return $rsUpload['data']; else $paramsNew = $rsUpload['data'];
            }

            $result = Self::insert($paramsNew);
        }

        if($options['task'] == 'edit'){
            $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));
            $paramsNew['modified_by'] = $loginUserId;
            $paramsNew['dob'] = Carbon::parse($paramsNew['dob'])->format('Y-m-d');
            $paramsNew['cccd_dos'] = Carbon::parse($paramsNew['cccd_dos'])->format('Y-m-d');

            foreach($typeImages as $type){
                $rsUpload = $this->processImage($type, $params, $paramsNew, $delOldImage = true);
                if($rsUpload == 1) continue;
                if($rsUpload['status'] == false)
                    return $rsUpload['data'];
                else
                    $paramsNew = $rsUpload['data'];
            }

            $result = Self::where('id', $id)->update($paramsNew);
        }

        if($options['task'] == 'change-password'){
            $params['password']       = md5($params['password']);
            $result = Self::where('id', $id)->update(['password' => $params['password']]);
        }

        return $result;
    }

    public function getItem($params = null, $options = null){
        $result = null;
        if($options['task'] == 'get-item'){
            $result = Self::select('*')->where('id', $params['id'])->first();
        }

        if($options['task'] == 'get-item-with-hop-dong'){
            $query = Self::select(DB::raw('main.*, hd.id as hop_dong_id'));
            $query->from($this->table.' as main');
            $query->leftJoin('hop_dongs as hd', 'hd.cong_dan_id', '=', 'main.id');
            if($params['id'] == 'ALL') {
                $query->where('main.status', 'active');
            }else{
                $query->where('main.id', $params['id']);
            }
                $result = ($query) ? $query->get()->toArray() : null;
        }

        if($options['task'] == 'do-login'){
            $result = Self::select(['id', 'username', 'fullname', 'email', 'status', 'level', 'avatar'])
                        ->firstWhere(['email' => $params['email'], 'password' => md5($params['password']), 'status' => 'active']);
            $result = ($result) ? $result->toArray() : null;
        }
        return $result;
    }

    public function processImage($obj, $params, $paramsNew, $delOldImage = false){
        $path = Config::get("custom.enum.path.".$this->uploadDir.".$obj");
        if(isset($params[$obj]) && $params[$obj]){
            $uploadRS = Resource::uploadImage($path, $params[$obj]);
            if($uploadRS){
                if($delOldImage) Resource::delete($path, $params[$obj."_current"]);
                $paramsNew[$obj] = $uploadRS;
                return ['status' => true, 'data' => $paramsNew];
            }else
                return ['status' => false, 'data' => "Upload $obj error.."];
        }
        return 1;
    }
}
