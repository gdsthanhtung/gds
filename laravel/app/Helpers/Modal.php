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
        $htmlNhanKhau = "<ul class='cursor-pointer' data-bs-toggle='modal' data-bs-target='#nhanKhauModal$hopDongId'>$nhanKhauInfo</ul>";

        foreach($nhanKhau as $item) {
            $avatar         = ($item['avatar']) ? 'avatar/'.$item['avatar'] : Config::get("custom.enum.defaultPath.avatar");
            $avatar         = Template::showItemAvatar('congdan', $avatar, $item['fullname']);
            $nhanKhauDetail[] = '
            <form>
                <div class="row mb-3">
                    <div class="col-3 text-center align-self-center">
                        '.$avatar.'
                    </div>
                    <div class="col-9">
                        <h6 class="card-title ttnk-list">'.$item['fullname'].'<span> | '.$mqhEnum[$item['mqh_chu_phong']].'</span></h6>
                        CCCD: '.$item['cccd_number'].' <br>
                        Ngày cấp: '.Template::showDate($item['cccd_dos']).' <br>
                        Trạng thái: '.$statusEnum[$item['status']].' <br>
                        Ngày sinh: '.Template::showDate($item['dob']).' <br>
                        Giới tính: '.$genderEnum[$item['gender']].' <br>
                    </div>
                </div>
            </form>';
        }

        $nhanKhauDetail = implode('<hr>', $nhanKhauDetail);

        $modal = "
            <div class='modal fade nhanKhauModal' id='nhanKhauModal$hopDongId' tabindex='-1' aria-hidden='true'>
                <div class='modal-dialog modal-MD'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                                <h5 class='modal-title'>THÔNG TIN NHÂN KHẨU</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <div class='content'>$nhanKhauDetail</div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
        ";

        return $htmlNhanKhau.$modal;
    }
}


