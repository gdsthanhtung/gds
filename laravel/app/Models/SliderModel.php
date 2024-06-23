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

    public function listItems($params, $options){
        $result = null;
        $filterStatus = $params['filter']['status'];
        $perPage = $params["pagination"]['perPage'];

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('*');
            if($filterStatus != 'all'){
                $query->where('status', $filterStatus);
            }
            $result = $query->orderBy('id', 'desc')->paginate($perPage);
        }

        return $result;
    }

    public function countItems($params, $options){
        $result = null;
        if($options['task'] == 'admin-count-items'){
            $result = Self::selectRaw('count(id) as total, status')
                        ->groupBy('status')
                        ->get()->toArray();
        }
        return $result;
    }
}
