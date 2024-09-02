<?php
namespace App\Helpers;
use Config;
use Carbon\Carbon;

class Template {
    public static function showNum($data, $currency = false){
        $c = ($currency) ? ' đ' : '';
        return number_format($data, 0, ',', '.').$c;
    }

    public static function showDate($date, $compareToday = false, $separator = false){
        $d = sprintf ("%s", date(Config::get('custom.format.shortTime'), strtotime($date)));
        if($compareToday == false){
            if($separator) $d = str_replace('-', $separator, $d);
            return $d;
        }else{
            if($separator) $d = str_replace('-', $separator, $d);
            $rs = (strtotime($date) >= strtotime(Carbon::now())) ? $d : '<span class="badge badge-danger">'.$d.'</span>';
            return $rs;
        }
    }

    public static function showDateDKTT($date, $compareMonthAgo = 0){
        $d = sprintf ("%s", date(Config::get('custom.format.shortTime'), strtotime($date)));
        $rs = (strtotime(Carbon::now()) >= strtotime(Carbon::parse($date)->subMonth($compareMonthAgo))) ? '<span class="badge badge-danger">'.$d.'</span>' : $d;
        return $rs;
    }

    public static function showItemHistory($by, $time){
        return sprintf ("
            <span class='text-secondary'><small><em><i class='bi bi-person'></i> %s <br> <i class='bi bi-clock'></i> %s </em></small></span>
        ", $by, date(Config::get('custom.format.shortTime'), strtotime($time)));
    }

    public static function showItemStatus($ctrl, $id, $status){
        $rule = Config::get('custom.enum.ruleStatus');
        $tpl = (isset($rule[$status])) ? $rule[$status] : $rule['unknown'];
        $link = route($ctrl.'/change-status', ['id' => $id, 'status' => $status]);
        return sprintf ("<a href='%s' type='button' class='btn btn-sm rounded-pill btn-%s'>%s</a>", $link, $tpl['class'], $tpl['name']);
    }

    public static function showItemStatusHoaDon($ctrl, $id, $status){
        $rule = Config::get('custom.enum.ruleStatusHoaDon');
        $tpl = (isset($rule[$status])) ? $rule[$status] : $rule['unknown'];
        $link = route($ctrl.'/change-status', ['id' => $id, 'status' => $status]);
        return sprintf ("<a href='%s' type='button' class='btn btn-sm btn-%s'>%s</a>", $link, $tpl['class'], $tpl['name']);
    }

    public static function showItemThumb($ctrl, $img, $alt){
        return sprintf (" <img src=%s }} alt=%s class='zvn-thumb'> ", asset("images/$ctrl/$img"), $alt);
    }

    public static function showItemCCCD($ctrl, $img, $alt){
        return sprintf (" <img src=%s }} alt=%s class='zvn-cccd'> ", asset("images/$ctrl/$img"), $alt);
    }

    public static function showItemAvatar($ctrl, $img, $alt){
        return sprintf ("<img src='%s' class='img-circle img-user-mgmt'>", asset("images/$ctrl/$img"), $alt);
    }

    public static function showActionButton($ctrl, $id){
        $rule = Config::get('custom.enum.ruleBtn');

        $btnInArea = Config::get('custom.enum.btnInArea');

        $ctrl = (array_key_exists($ctrl, $btnInArea)) ? $ctrl : 'default';
        $listBtn = $btnInArea[$ctrl];
        $html = "";

        foreach($listBtn as $item){
            $button = $rule[$item];
            $link = route($ctrl.$button['route'], ['id' => $id]);
            $html .= sprintf('<a href="%s" type="button" class="rounded-pill btn btn-sm btn-icon %s" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="%s">
                                <i class="bi %s"></i>', $link, $button['class'], $button['title'], $button['icon']);
        }
        $html = '<div class="zvn-box-btn-filter">'.$html.'</div>';
        return $html;
    }

    public static function showButtonFilter($ctrl, $countByStatus, $params, $enum = 'ruleStatus'){
        $html = "";
        $rule = Config::get('custom.enum.'.$enum);

        $searchValue    = ($params["filter"]['searchValue']) ? '&searchValue='.$params["filter"]['searchValue'] : '';
        $searchField    = ($params["filter"]['searchValue']) ? '&searchField='.$params["filter"]['searchField'] : '';

        if($countByStatus) {
            array_unshift($countByStatus, [
                'total' => array_sum(array_column($countByStatus, 'total')),
                'status' => 'all'
            ]);
            foreach($countByStatus as $item){
                $status = $item['status'];
                $tpl = (isset($rule[$status])) ? $rule[$status] : $rule['unknown'];

                $link = route($ctrl).'?status='.$status.$searchField.$searchValue;
                $class = ($params['filter']['status'] == $status) ? $tpl['class'] : 'secondary';
                $html .= sprintf('<a href="%s" type="button" class="btn btn-%s md-2 mr-5">%s <span class="badge bg-white text-%s">%s</span></a>',
                                    $link, $class, ucfirst($tpl['name']), $class, $item['total']);
            }
        }
        return $html;
    }

    public static function showSearchArea($ctrl, $params, $searchSelection = 'searchSelection'){
        $html = "";
        $selections = "";

        extract($params);
        $searchField = $filter['searchField'];
        $searchValue = $filter['searchValue'];

        $rule = Config::get('custom.enum.'.$searchSelection);
        $selectionInModule = Config::get('custom.enum.selectionInModule');
        $ctrl = (isset($selectionInModule[$ctrl]))  ? $ctrl : 'default';

        foreach($selectionInModule[$ctrl] as $item){
            $selections .= sprintf("<option class='select-field' data-field='%s'>%s</option>",  $item, $rule[$item]['name']);
        }

        $html = sprintf('<div class="input-group">
                    <select class="form-select" aria-label="Bộ lọc">
                        %s
                    </select>
                    <input type="text" class="form-control mr-5 input-br" name="searchValue" value="%s">
                    <input type="hidden" name="searchField" value="%s">
                    <span class="input-group-btn">
                        <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                        <button id="btn-clear" type="button" class="btn btn-success">Xóa tìm kiếm</button>
                    </span>
                </div>', $selections, $searchValue, $searchField);

        return $html;
    }

    public static function showItemSelect($ctrl, $id, $displayValue, $fieldName)
    {
       $link          = route($ctrl . '/change-' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);

       $tmplDisplay = Config::get('custom.enum.select' . ucfirst($fieldName));
       $html = sprintf('<select name="selectChangeAttr" data-url="%s" class="form-select">', $link  );

        foreach ($tmplDisplay as $key => $value) {
           $htmlSelected = '';
           if ($key == $displayValue) $htmlSelected = 'selected="selected"';
            $html .= sprintf('<option value="%s" %s>%s</option>', $key, $htmlSelected, $value);
        }
        $html .= '</select>';

        return $html;
    }

    public static function radioSelect($listToSelect = [], $elName = 'noname', $valToChecked = null){
        $html = '';
        foreach ($listToSelect as $value => $title) {
            $checked = ($value === $valToChecked) ? 'checked' : '';
            $html .= "<div class='form-check form-check-inline'>
                        <input class='form-check-input' type='radio' name='$elName' id='$elName$value' value='$value' $checked>
                        <label class='form-check-label' for='$elName$value'>$title</label>
                    </div>";
        }
        return $html;
    }

    public static function buildNhanKhauInHopDong($id, $nkInHopDong = []){
        $mqhEnum = Config::get('custom.enum.mqh');
        $nkIdOptionSelected = [];
        $nkNameOptionSelected = [];
        $mqhIdOptionSelected = [];
        $mqhNameOptionSelected = [];
        $initNkSelected = '';
        if($nkInHopDong){
            foreach($nkInHopDong[$id] as $nk){
                $nkInfo = $nk['fullname'].' - '.$nk['cccd_number'].' - '.$nk['status'];
                $initNkSelected .= '<div class="alert alert-info alert-dismissible init-nk-selected">';
                $initNkSelected .= '<button type="button" class="close"><span aria-hidden="true" class="remove-cong-dan" cong-dan-id="'.$nk['cong_dan_id'].'">&times;</span></button>';
                $initNkSelected .= $nk['fullname'].' - '.$nk['cccd_number'].' - '.$nk['status'].' <strong> ('.$mqhEnum[$nk['mqh_chu_phong']].') </strong>';
                $initNkSelected .= '</div>';
                $nkIdOptionSelected[]       = (string)$nk['cong_dan_id'];
                $nkNameOptionSelected[]     = $nkInfo;
                $mqhIdOptionSelected[]      = (string)$nk['mqh_chu_phong'];
                $mqhNameOptionSelected[]    = $mqhEnum[$nk['mqh_chu_phong']];
            }
        }else{
            $initNkSelected = '<div class="alert alert-warning alert-dismissible init-nk-selected">Vui lòng chọn nhân khẩu từ danh sách bên cạnh!</div>';
        }
        return [
            'initNkSelected'        => $initNkSelected,
            'nkIdOptionSelected'    => $nkIdOptionSelected,
            'nkNameOptionSelected'  => $nkNameOptionSelected,
            'mqhIdOptionSelected'   => $mqhIdOptionSelected,
            'mqhNameOptionSelected' => $mqhNameOptionSelected,
        ];
    }

    public static function buildSelectCongDanList($dataCongDan = [], $nkIdOptionSelected){
        $selectCongDanList = '<select class="form-control col-md-7 col-xs-12" id="cong_dan_list" name="cong_dan_list"><option value="">Select an item...</option>';
        if($dataCongDan) foreach ($dataCongDan as $cdId => $cd) {
            $disable = (in_array($cdId, $nkIdOptionSelected)) ? 'disabled="disabled" class="selected-option"' : '';
            $selectCongDanList .= "<option $disable value='$cdId'>$cd</option>";
        }
        $selectCongDanList .= '</select>';
        return $selectCongDanList;
    }

    public static function ct01($cdId, $task = 'NEW', $withFamify = false){
        $text = ($cdId == 'ALL') ? "$cdId-CT01-$task" : "CT01-$task";
        $class = ($task == 'NEW') ? 'primary' : 'warning';
        return "<a href=".route('congdan/ct01', ['id' => $cdId, 'task' => $task, 'withFamily' => $withFamify])." target='_blank' class='btn btn-$class'>$text</a>";
    }
}
