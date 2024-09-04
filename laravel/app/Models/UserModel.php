<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Resource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $uploadDir = 'user';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $crudNotAccepted = ['_token', 'avatar', 'avatar_current', 'password_confirmation', 'task'];

    public function listItems($params = null, $options = null){
        $this->table = $this->table.' as main';
        $result = null;
        $perPage = $params["pagination"]['perPage'];

        $filterStatus   = $params['filter']['status'];
        $searchField    = $params['filter']['searchField'];
        $searchValue    = $params["filter"]['searchValue'];
        $fieldAccepted  = $params["filter"]['fieldAccepted'];

        if($options['task'] == 'admin-list-items'){
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

        if($options['task'] == 'change-status'){
            $paramsNew = $params;
            $paramsNew['status'] = ($params['status'] == 'active') ? 'inactive' : 'active';
            $paramsNew['modified_by'] = $loginUserId;
            $result = Self::where('id', $id)->update($paramsNew);
        }

        if($options['task'] == 'change-level'){
            $paramsNew = $params;
            $paramsNew['modified_by'] = $loginUserId;
            $result = Self::where('id', $id)->update($paramsNew);
        }

        if($options['task'] == 'add'){
            $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));
            $paramsNew['created'] = Carbon::now();
            $paramsNew['created_by'] = $paramsNew['modified_by'] = $loginUserId;
            $paramsNew['password']       = md5($params['password']);

            if(isset($params['avatar']) && $params['avatar']){
                $uploadRS = Resource::uploadImage($this->uploadDir, $params['avatar'], 'avatar');
                if($uploadRS)
                    $paramsNew['avatar'] = $uploadRS;
                else
                    return "Upload error..";
            }

            $result = Self::insert($paramsNew);
        }

        if($options['task'] == 'edit'){
            $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));
            $paramsNew['modified_by'] = $loginUserId;

            if(isset($params['avatar']) && $params['avatar']){
                $uploadRS = Resource::uploadImage($this->uploadDir, $params['avatar'], 'avatar');
                if($uploadRS)
                    $paramsNew['avatar'] = $uploadRS;
                else
                    return "Upload error..";
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

        if($options['task'] == 'do-login'){
            $result = Self::select(['id', 'username', 'fullname', 'email', 'status', 'level', 'avatar'])
                        ->firstWhere(['email' => $params['email'], 'password' => md5($params['password']), 'status' => 'active']);
            $result = ($result) ? $result->toArray() : null;
        }
        return $result;
    }
}
