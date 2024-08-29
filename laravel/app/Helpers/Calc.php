<?php
namespace App\Helpers;
use App\Helpers\Template;
use Config;

class Calc {
    public static function calcE($range, $used, $pdf = false){
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
                if($pdf){
                    $htmlDetail .= '<tr><td class="right line-dotted">'.$x.' kw</td><td class="right line-dotted">'.Template::showNum($price, true).'</td><td class="right line-dotted">'.Template::showNum($x*$price, true).'</td></tr>';
                }else{
                    $htmlDetail .= '<tr><th scope="row">'.($i+1).'</th><td>'.$x.'</td><td>'.Template::showNum($price, true).'</td><td>'.Template::showNum($x*$price, true).'</td></tr>';
                }
                $eCaled += $x;
                break;
            }else{
                $cost += ($limit*$price);
                if($pdf){
                    $htmlDetail .= '<tr><td class="right line-dotted">'.$limit.' kw</td><td class="right line-dotted">'.Template::showNum($price, true).'</td><td class="right line-dotted">'.Template::showNum($limit*$price, true).'</td></tr>';
                }else{
                    $htmlDetail .= '<tr><th scope="row">'.($i+1).'</th><td>'.$limit.'</td><td>'.Template::showNum($price, true).'</td><td>'.Template::showNum($limit*$price, true).'</td></tr>';
                }
                $eCaled += $limit;
            }

        }

        if($htmlDetail){
            if($pdf){
                $htmlDetail .= '<tr><td colspan="3" class="right">'.Template::showNum($cost, true).'</td></tr>';
            }else{
                $htmlDetail .= '<tr><th scope="row">Tổng</th><td colspan="2">'.Template::showNum($eCaled).'(kw)</td><td>'.Template::showNum($cost, true).'</td></tr>';
            }
        }
        if($pdf){
            $tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><tbody>'.$htmlDetail.'</tbody></table>';
        }else{
            $tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><thead><tr><th scope="col">#</th><th scope="col">Lượng điện (kw)</th><th scope="col">Giá</th><th scope="col">Số tiền</th></tr></thead><tbody>'.$htmlDetail.'</tbody></table>';
        }
        return $tableHtml;
    }

    public static function calcW($detail, $pdf = false){
        if($pdf == false){
            $detail = json_decode($detail);
            return $detail->html;
        }else{
            $detailW = (json_decode($detail))->param;
            $m3ForPerson0 = $detailW->m3ForPerson0;
            $costForPerson0 = $detailW->costForPerson0;
            $costW = $detailW->cost;
            $usedW = $detailW->used;
            $rangePrice = $detailW->rangePrice;
            if($detailW->over > 0){
                $m3ForPerson1 = $detailW->m3ForPerson1 + $detailW->over;
                $costForPerson1 = $detailW->costForPerson1 + $detailW->overCost;
            }else{
                $m3ForPerson1 = $detailW->m3ForPerson1;
                $costForPerson1 = $detailW->costForPerson1;
            }

            $html0 = $html1 = '';
            if($m3ForPerson0 > 0){
                $html0 .= "
                    <tr>
                        <td class='right line-dotted'>$m3ForPerson0 m&sup3;</td>
                        <td class='right line-dotted'>".Template::showNum($rangePrice[0], true) ."</td>
                        <td class='right line-dotted'>".Template::showNum($costForPerson0, true) ."</td>
                    </tr>
                ";
            }
            if($m3ForPerson1 > 0){
                $html1 .= "
                    <tr>
                        <td class='right line-dotted'>$m3ForPerson1 m&sup3;</td>
                        <td class='right line-dotted'>".Template::showNum($rangePrice[1], true) ."</td>
                        <td class='right line-dotted'>".Template::showNum($costForPerson1, true) ."</td>
                    </tr>
                ";
            }

            $html = "
                <table width='100%'>
                    <tbody>
                        $html0 $html1
                        <tr >
                            <td class='right'></td>
                            <td class='right'></td>
                            <td class='right'>".Template::showNum($costW, true) ."</td>
                        </tr>
                    </tbody>
                </table>
            ";
            return $html;

        }
    }
}
