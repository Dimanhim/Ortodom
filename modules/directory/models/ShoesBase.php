<?php

namespace app\modules\directory\models;

use Yii;
use yii\db\ActiveRecord;

class ShoesBase extends ActiveRecord
{

    public $full_color_ids = [];


    public function afterFind()
    {

        return parent::afterFind();
    }

    public function getColorsString()
    {
        if($this->full_color_ids) {
            return Yii::$app->controller->renderPartial('/shoes-brand/_colors_list', [
                'colors' => $this->full_color_ids,
                'model' => $this,
            ]);
        }
        return false;
    }
    public function getModelColorsString()
    {
        if($this->color_ids) {
            return Yii::$app->controller->renderPartial('/shoes-brand/_colors_list', [
                'colors' => $this->color_ids,
                'model' => $this,
            ]);
        }
        return false;
    }
    public function getColor($color_id)
    {
        return ShoesColor::findOne($color_id);
    }
}
