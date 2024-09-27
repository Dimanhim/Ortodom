<?php

namespace app\components;

use Picqer\Barcode\BarcodeGeneratorSVG;

class Helpers
{
    public $default = '4797001018719';
    static $_problem_sign = ' <span class="problem-star">★</span>';

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

    public static function formatPhone($phone)
    {
        $symbols = [' ', '-'];
        $replaced = ['', ''];
        return str_replace($symbols, $replaced, $phone);
    }

    public static function setBasePhoneFormat($phone)
    {
        $pattern = '/[^0-9]/';
        $phoneNumber = '';
        $str = preg_replace($pattern, '', $phone);
        if(mb_strlen($str) == 11) {
            $phoneNumber .= '+';
            $phoneNumber .= $str[0];
            $phoneNumber .= '-';
            $phoneNumber .= $str[1].$str[2].$str[3].'-';
            $phoneNumber .= $str[4].$str[5].$str[6].'-';
            $phoneNumber .= $str[7].$str[8].'-';
            $phoneNumber .= $str[9].$str[10];
        }
        return $phoneNumber;
    }
}
