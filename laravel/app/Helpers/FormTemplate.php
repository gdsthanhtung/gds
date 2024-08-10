<?php
namespace App\Helpers;

class FormTemplate {
    public static function export($element){
        $html = "";

        foreach($element as $item){
            $type = isset($item['type']) ? $item['type'] : 'input';
            $colClass = isset($item['elClass']) ? $item['elClass'] : 'col-md-6 col-sm-6 col-xs-12';

            switch ($type) {
                case 'input':
                    $html .= sprintf('
                        <div class="form-group">
                            %s
                            <div class="%s"> %s </div>
                        </div>', $item['label'], $colClass, $item['el']);
                    break;

                case 'btn-submit':
                    $html .= sprintf('
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="%s col-md-offset-3"> %s </div>
                        </div>', $colClass, $item['el']);
                    break;

                case 'thumb':
                    $html .= sprintf('
                        <div class="form-group">
                            %s
                            <div class="%s">
                                %s
                                <p style="margin-top: 50px;"> %s </p>
                            </div>
                        </div>', $item['label'], $colClass, $item['el'], $item['thumb']);
                    break;


                case 'avatar':
                    $html .= sprintf('
                        <div class="form-group">
                            %s
                            <div class="%s">
                                %s
                                <p style="margin-top: 50px;"> %s </p>
                            </div>
                        </div>', $item['label'], $colClass, $item['el'], $item['avatar']);
                    break;

                default:
                    break;
            }
        }
        return $html;
    }
}
