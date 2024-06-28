<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SliderModel extends Model
{
    use HasFactory;
    protected $table = 'slider';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

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
        $result = Self::where('id', $params['id'])->delete();
        return $result;
    }

    public function saveItem($params = null, $options = null){
        $result = null;
        if($options['task'] == 'change-status'){
            $newStatus = ($params['status'] == 'active') ? 'inactive' : 'active';
            $result = Self::where('id', $params['id'])
                        ->update(['status' => $newStatus]);
        }
        return $result;
    }
}
