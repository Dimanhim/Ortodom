<?php

namespace app\components;

use Picqer\Barcode\BarcodeGeneratorSVG;

class Helpers
{
    public $default = '4797001018719';

    public static function generateBarcode($code)
    {
        $str = '<div class="barcode-container">';
        $generator = new BarcodeGeneratorSVG();
        $str .= '<div class="barcode-content">';
        $str .= $generator->getBarcode($code, $generator::TYPE_CODE_128, 2, 40);
        $str .= '</div>';
        $str .= '<div class="barcode-numbers">';
        $str .= $code;
        $str .= '</div>';
        $str .= '</div>';
        return $str;
    }
    public static function getContainerClass($controller, $action)
    {
        $controllers = ['order', 'patient'];
        $actions = ['create'];
        if(in_array($controller, $controllers) and in_array($action, $actions))
            return ' background-f2';
        return '';
    }
}
