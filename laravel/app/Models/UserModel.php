<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Resource;
use Carbon\Carbon;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $uploadDir = 'user';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $crudNotAccepted = ['_token', 'avatar', 'avatar_current', 'password_confirmation', 'task'];

    public function listItems($params = null, $options = null){
        $result = null;
        $perPage = $params["pagination"]['perPage'];

        $filterStatus   = $params['filter']['status'];
        $searchField    = $params['filter']['searchField'];
        $searchValue    = $params["filter"]['searchValue'];
        $fieldAccepted  = $params["filter"]['fieldAccepted'];

        if($options['task'] == 'admin-list-items'){
            $query = Self::select('*');
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

            if($filterStatus != 'all'){
                $query->where('status', $filterStatus);
            }
            $result = $query->orderBy('id', 'desc')->paginate($perPage);
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
        $params['modified_by'] = 'tunghuynh';
        $params['modified'] = Carbon::now();
        $id = (isset($params['id'])) ? $params['id'] : null;

        if($options['task'] == 'change-status'){
            $newStatus = ($params['status'] == 'active') ? 'inactive' : 'active';
            $result = Self::where('id', $id)->update(['status' => $newStatus]);
        }

        if($options['task'] == 'change-level'){
            $result = Self::where('id', $id)->update(['level' => $params['level']]);
        }

        if($options['task'] == 'add'){
            $paramsNew                   = array_diff_key($params, array_flip($this->crudNotAccepted));
            $paramsNew['created']        = Carbon::now();
            $paramsNew['created_by']     = 'tunghuynh';
            $paramsNew['modified_by']    = null;
            $paramsNew['modified']       = null;
            $paramsNew['password']       = md5($params['password']);

            if(isset($params['avatar']) && $params['avatar']){
                $uploadRS = Resource::upload($this->uploadDir, $params['avatar']);
                if($uploadRS)
                    $paramsNew['avatar'] = $uploadRS;
                else
                    return "Upload error..";
            }

            $result = Self::insert($paramsNew);
        }

        if($options['task'] == 'edit'){
            $paramsNew = array_diff_key($params, array_flip($this->crudNotAccepted));

            if(isset($params['avatar']) && $params['avatar']){
                $uploadRS = Resource::upload($this->uploadDir, $params['avatar']);
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
        return $result;
    }
}
