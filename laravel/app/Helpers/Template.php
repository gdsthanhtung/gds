<?php
namespace App\Helpers;
use Config;

class Template {
    public static function showItemHistory($by, $time){
        return sprintf ("
            <p><i class='fa fa-user'></i> %s </p>
            <p><i class='fa fa-clock-o'></i> %s </p>
        ", $by, date(Config::get('custom.format.shortTime'), strtotime($time)));
    }

    public static function showItemStatus($ctrl, $id, $status){
        $rule = Config::get('custom.enum.status');
        $tpl = (isset($rule[$status])) ? $rule[$status] : $rule['unknown'];
        $link = route($ctrl.'/change-status', ['id' => $id, 'status' => $status]);
        return sprintf ("<a href='%s' type='button' class='btn btn-round %s'>%s</a>", $link, $tpl['class'], $tpl['name']);
    }

    public static function showItemThumb($ctrl, $thumb, $alt){
        return sprintf (" <img src=%s }} alt=%s class='zvn-thumb'> ", asset("images/$ctrl/$thumb"), $alt);
    }

    public static function showActionButton($ctrl, $id){
        $ruleBtn = [
            'edit'      => ['class' => 'btn-success',   'title' => 'Điều chỉnh',    'icon' => 'fa-pencil',  'route' => "$ctrl/form"],
            'delete'    => ['class' => 'btn-danger',    'title' => 'Xoá',           'icon' => 'fa-trash',   'route' => "$ctrl/delete"],
            'info'      => ['class' => 'btn-info',      'title' => 'Thông tin',     'icon' => 'fa-info',    'route' => "$ctrl/info"],
        ];

        $btnInArea = [
            'default' => ['edit', 'delete'],
            'slider' => ['edit', 'delete']
        ];

        $ctrl = (array_key_exists($ctrl, $btnInArea)) ? $ctrl : 'default';
        $listBtn = $btnInArea[$ctrl];
        $html = "";

        foreach($listBtn as $item){
            $button = $ruleBtn[$item];
            $link = route($button['route'], ['id' => $id]);
            $html .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                <i class="fa %s"></i></a>', $link, $button['class'], $button['title'], $button['icon']);
        }
        $html = '<div class="zvn-box-btn-filter">'.$html.'</div>';
        return $html;
    }

    public static function showButtonFilter($ctrl, $countByStatus, $params){
        $html = "";
        $rule = Config::get('custom.enum.status');

        if($countByStatus) {
            array_unshift($countByStatus, [
                'total' => array_sum(array_column($countByStatus, 'total')),
                'status' => 'all'
            ]);
            foreach($countByStatus as $item){
                $status = $item['status'];
                $tpl = (isset($rule[$status])) ? $rule[$status] : $rule['unknown'];

                $link = route($ctrl).'?status='.$status;
                $class = ($params['filter']['status'] == $status) ? $tpl['class'] : 'btn-info';
                $html .= sprintf('<a href="%s" type="button" class="btn %s">%s <span class="badge bg-white">%s</span></a>',
                                    $link, $class, ucfirst($tpl['name']), $item['total']);
            }
            $html = '<div class="zvn-box-btn-filter">'.$html.'</div>';
        }

        return $html;
    }
}
