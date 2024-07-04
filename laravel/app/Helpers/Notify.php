<?php
namespace App\Helpers;
use Config;

class Notify {
    public static function export($data){
        $notify = ($data) ? ['type' => 'success', 'message' => 'Yêu cầu thực hiện thành công!'] : ['type' => 'danger', 'message' => 'Yêu cầu thực hiện thất bại'];
        return $notify;
    }
}
