<?php
namespace App\Helpers;
use Config;

class Template {
    public static function showItemHistory($by, $time){
        return sprintf ("
            <p><i class='fa fa-user'></i> %s <br> <i class='fa fa-clock-o'></i> %s </p>
        ", $by, date(Config::get('custom.format.shortTime'), strtotime($time)));
    }

    public static function showItemStatus($ctrl, $id, $status){
        $rule = Config::get('custom.enum.ruleStatus');
        $tpl = (isset($rule[$status])) ? $rule[$status] : $rule['unknown'];
        $link = route($ctrl.'/change-status', ['id' => $id, 'status' => $status]);
        return sprintf ("<a href='%s' type='button' class='btn btn-round %s'>%s</a>", $link, $tpl['class'], $tpl['name']);
    }

    public static function showItemThumb($ctrl, $thumb, $alt){
        return sprintf (" <img src=%s }} alt=%s class='zvn-thumb'> ", asset("images/$ctrl/$thumb"), $alt);
    }

    public static function showItemAvatar($ctrl, $avatar, $alt){
        return sprintf ("<img src='%s' class='img-circle img-user-mgmt'>", asset("images/$ctrl/$avatar"), $alt);
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
            $html .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                <i class="fa %s"></i></a>', $link, $button['class'], $button['title'], $button['icon']);
        }
        $html = '<div class="zvn-box-btn-filter">'.$html.'</div>';
        return $html;
    }

    public static function showButtonFilter($ctrl, $countByStatus, $params){
        $html = "";
        $rule = Config::get('custom.enum.ruleStatus');

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
                $class = ($params['filter']['status'] == $status) ? $tpl['class'] : 'btn-info';
                $html .= sprintf('<a href="%s" type="button" class="btn %s">%s <span class="badge bg-white">%s</span></a>',
                                    $link, $class, ucfirst($tpl['name']), $item['total']);
            }
            $html = '<div class="zvn-box-btn-filter">'.$html.'</div>';
        }

        return $html;
    }

    public static function showSearchArea($ctrl, $params){
        $html = "";
        $selections = "";

        extract($params);
        $searchField = $filter['searchField'];
        $searchValue = $filter['searchValue'];

        $rule = Config::get('custom.enum.searchSelection');
        $selectionInModule = Config::get('custom.enum.selectionInModule');
        $ctrl = (isset($selectionInModule[$ctrl]))  ? $ctrl : 'default';

        foreach($selectionInModule[$ctrl] as $item){
            $selections .= sprintf("<li><a href='' class='select-field' data-field='%s'>%s</a></li>",  $item, $rule[$item]['name']);
        }

        $html = sprintf('<div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle btn-active-field"
                            data-toggle="dropdown" aria-expanded="false">
                            %s <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu"> %s </ul>
                    </div>
                    <input type="text" class="form-control" name="searchValue" value="%s">
                    <input type="hidden" name="searchField" value="%s">
                    <span class="input-group-btn">
                        <button id="btn-clear" type="button" class="btn btn-success"
                            style="margin-right: 0px">Xóa tìm kiếm</button>
                        <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                    </span>
                </div>', $rule[$searchField]['name'], $selections, $searchValue, $searchField);

        return $html;
    }

    public static function showItemSelect($ctrl, $id, $displayValue, $fieldName)
    {
       $link          = route($ctrl . '/change-' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);

       $tmplDisplay = Config::get('custom.enum.select' . ucfirst($fieldName));
       $html = sprintf('<select name="selectChangeAttr" data-url="%s" class="form-control">', $link  );

        foreach ($tmplDisplay as $key => $value) {
           $htmlSelected = '';
           if ($key == $displayValue) $htmlSelected = 'selected="selected"';
            $html .= sprintf('<option value="%s" %s>%s</option>', $key, $htmlSelected, $value);
        }
        $html .= '</select>';

        return $html;
    }
}
