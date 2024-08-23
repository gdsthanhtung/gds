<?php
namespace App\Helpers;
use App\Helpers\Template;
use Config;

class Calc {
    public static function calcE($range, $used){
        $cost = 0;
        $eCaled = 0;
        $htmlDetail = '';
        $range = json_decode($range, true);
        $range = $range['detail'];
        for ($i = 0; $i < count($range); $i++) {
            $limit = $range[$i]['limit'];
            $price = $range[$i]['price'];
            $e = $used - ($limit + $eCaled);
            if($e < 0){
                $x = $used - $eCaled;
                $cost += ($x*$price);
                $htmlDetail .= '<tr><th scope="row">'.($i+1).'</th><td>'.$x.'</td><td>'.Template::showNum($price, true).'</td><td>'.Template::showNum($x*$price, true).'</td></tr>';
                break;
            }else{
                $cost += ($limit*$price);
                $htmlDetail .= '<tr><th scope="row">'.($i+1).'</th><td>'.$limit.'</td><td>'.Template::showNum($price, true).'</td><td>'.Template::showNum($limit*$price, true).'</td></tr>';
            }
            $eCaled += $limit;
        }

        if($htmlDetail){
            $htmlDetail .= '<tr><th scope="row">Tổng</th><td colspan="2">'.Template::showNum($eCaled).'(kw)</td><td>'.Template::showNum($cost, true).'</td></tr>';
        }
        $tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><thead><tr><th scope="col">#</th><th scope="col">Lượng điện (kw)</th><th scope="col">Giá</th><th scope="col">Số tiền</th></tr></thead><tbody>'.$htmlDetail.'</tbody></table>';
        return $tableHtml;
    }

    public static function calcW($range, $used, $isCity){
        $range = json_decode($range, true);
        $range = $range['detail'];
        $cost = $used * $range[$isCity];
        $htmlDetail  = '<tr><th scope="row">Tổng</th><td>'.Template::showNum($used).'(m3)</td><td>'.Template::showNum($range[$isCity], true).'</td><td>'.Template::showNum($cost, true).'</td></tr>';
        $tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><thead><tr><th scope="col">#</th><th scope="col">Lượng nước (m3)</th><th scope="col">Giá</th><th scope="col">Số tiền</th></tr></thead><tbody>'.$htmlDetail.'</tbody></table>';
        return $tableHtml;
    }
}
