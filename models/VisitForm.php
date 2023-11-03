<?php

namespace app\models;

use yii\base\Model;

class VisitForm extends Model
{
    public $date;

    public function rules()
    {
        return [
            [['date'], 'safe'],
        ];
    }

    public function getModelDate()
    {
        return $this->date;
        if($this->date) {
            foreach($this->date as $date) {
                if($date) return $date;
            }
        }
        return false;
    }
}
