<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
    ];
    public $js = [
        //'js/jquery.printPage.js',
        //'js/order.js',
        //'js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function getCss()
    {
        return [
            'css/jquery-ui.css',
            'css/chosen.css',
            'jstree/themes/default/style.min.css',
            'css/site.css?v='.mt_rand(1000,10000),
        ];
    }
    public function getJs()
    {
        return [
            'js/jquery.printPage.js',
            'js/bootstrap.js',
            //'js/jquery-ui.min.js',
            'js/inputmask.js',
            'js/jquery.inputmask.js',
            'js/chosen.jquery.min.js',
            'jstree/jstree.min.js',
            'js/jstree-actions.min.js',
            'js/slugify.js',
            'js/order.js?v='.mt_rand(1000,10000),
            'js/common.js?v='.mt_rand(1000,10000),
        ];
    }


    public function init()
    {
        $this->css = self::getCss();
        $this->js = self::getJs();
    }
}
