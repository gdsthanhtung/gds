<?php
namespace App\Helpers;

class FormTemplate {
    public static function export($element){
        $html = "";

        foreach($element as $item){
            $type = isset($item['type']) ? $item['type'] : 'input';
            $colClass = isset($item['elClass']) ? $item['elClass'] : 'col-9';

            switch ($type) {
                case 'input':
                    $html .= sprintf('
                        <div class="row mb-3">
                            %s
                            <div class="%s"> %s </div>
                        </div>', $item['label'], $colClass, $item['el']);
                    break;

                case 'btn-submit':
                    $html .= sprintf('
                        <hr>
                        <div class="row mb-3">
                            <div class="%s offset-3"> %s </div>
                        </div>', $colClass, $item['el']);
                    break;

                case 'thumb':
                    $html .= sprintf('
                        <div class="row mb-3">
                            %s
                            <div class="%s">
                                %s
                                <p style="margin-top: 50px;"> %s </p>
                            </div>
                        </div>', $item['label'], $colClass, $item['el'], $item['thumb']);
                    break;


                case 'avatar':
                    $html .= sprintf('
                        <div class="row mb-3">
                            %s
                            <div class="%s">
                                <div class="mb-3">%s</div>%s
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
