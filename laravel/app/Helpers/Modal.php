<?php
namespace App\Helpers;
use Config;

class Modal {
    public static function showNhanKhau($hopDongId, $nhanKhau){
        if(!$nhanKhau) return '-';

        $html = $nhanKhauInfo = '';
        if($nhanKhau) foreach($nhanKhau as $nk){
            $nhanKhauInfo .= "<li>".$nk['fullname']."</li>";
        }
        $htmlNhanKhau = "<ul data-toggle='modal' data-target='#nhanhauModal$hopDongId' class='cursor-pointer'>$nhanKhauInfo</ul>";

        $modal = "
            <div class='modal fade nhanKhauModal' id='nhanKhauModal$hopDongId' tabindex='-1' role='dialog' aria-labelledby='Nhân Khẩu'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        <h4 class='modal-title' id='myModalLabel'>THÔNG TIN NHÂN KHẨU</h4>
                    </div>
                    <div class='modal-body'>
                        <div class='content'></div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    </div>
                    </div>
                </div>
            </div>
        ";

        return $htmlNhanKhau.$modal;
    }
}


