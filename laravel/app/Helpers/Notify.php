<?php
namespace App\Helpers;
use Config;

class Notify {
    public static function export($data, $customMsg = []){
        $sMsg = 'Yêu cầu thực hiện thành công!';
        $eMsg = 'Yêu cầu thực hiện thất bại!';
        if($customMsg){
            $sMsg = $customMsg['sMsg'];
            $eMsg = $customMsg['eMsg'];
        }
        $notify = ($data) ? ['type' => 'success', 'message' => $sMsg] : ['type' => 'danger', 'message' => $eMsg];
        return $notify;
    }
}
