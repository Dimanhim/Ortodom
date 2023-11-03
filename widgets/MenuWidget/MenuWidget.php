<?php

namespace app\widgets\MenuWidget;

use app\models\Page;
use app\models\Menu;
use Yii;

class MenuWidget extends \yii\base\Widget
{
    public $menu_id;
    public $model;

    public function init()
    {
        return parent::init();
    }

    public function run()
    {
        if($this->menu_id && ($menu = Menu::findOne($this->menu_id))) {
            return $this->render('index', [
                'menu' => $menu,
            ]);
        }
    }
}
