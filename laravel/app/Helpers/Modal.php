<?php
namespace App\Helpers;
use App\Helpers\Template;
use Config;

class Modal {
    public static function showNhanKhau($hopDongId, $nhanKhau){
        if(!$nhanKhau) return '-';

        $mqhEnum = Config::get('custom.enum.mqh');
        $genderEnum = Config::get('custom.enum.gender');
        $statusEnum = Config::get('custom.enum.selectStatus');

        $nhanKhauDetail = [];
        $nhanKhauInfo = '';
        if($nhanKhau) foreach($nhanKhau as $nk){
            $nhanKhauInfo .= "<li>".$nk['fullname']."</li>";
        }
        $htmlNhanKhau = "<ul class='cursor-pointer' data-toggle='modal' data-target='#nhanKhauModal$hopDongId'>$nhanKhauInfo</ul>";

        foreach($nhanKhau as $item) {
            $avatar         = ($item['avatar']) ? 'avatar/'.$item['avatar'] : Config::get("custom.enum.defaultPath.avatar");
            $avatar         = Template::showItemAvatar('congdan', $avatar, $item['fullname']);
            $nhanKhauDetail[] = '<div class="media">
                                    <div class="media-left media-middle">
                                        <a href="#">'.$avatar.'</a>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">'.$item['fullname'].' <br> ('.$mqhEnum[$item['mqh_chu_phong']].')</h5>
                                        CCCD: '.$item['cccd_number'].' <br>
                                        Ngày cấp: '.Template::showDate($item['cccd_dos']).' <br>
                                        Trạng thái: '.$statusEnum[$item['status']].' <br>
                                        Ngày sinh: '.Template::showDate($item['dob']).' <br>
                                        Giới tính: '.$genderEnum[$item['gender']].' <br>

                                    </div>
                                </div>';
        }

        $nhanKhauDetail = implode('<hr>', $nhanKhauDetail);

        $modal = "
            <div class='modal fade nhanKhauModal' id='nhanKhauModal$hopDongId' tabindex='-1' role='dialog' aria-labelledby='Nhân Khẩu'>
                <div class='modal-dialog modal-sm' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            <h4 class='modal-title' id='myModalLabel'>THÔNG TIN NHÂN KHẨU</h4>
                        </div>
                        <div class='modal-body'>
                            <div class='content'>$nhanKhauDetail</div>
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


