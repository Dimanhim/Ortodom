<?php

namespace app\models;

use app\modules\directory\models\Appointment;
use app\modules\directory\models\Shoes;
use app\modules\directory\models\ShoesBrand;
use app\modules\directory\models\ShoesColor;
use app\modules\directory\models\ShoesHeel;
use app\modules\directory\models\ShoesLast;
use app\modules\directory\models\ShoesLining;
use app\modules\directory\models\ShoesMaterial;
use app\modules\directory\models\ShoesModel;
use app\modules\directory\models\ShoesSole;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property integer $shoes_id
 * @property integer $brand_id
 * @property integer $material_id
 * @property integer $lining_id
 * @property integer $color
 * @property string $appointment_left
 * @property string $appointment_right
 * @property integer $heel_left
 * @property integer $heel_right
 * @property integer $sole_id
 * @property integer $last_id
 */
class BaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['name'], 'required'],
            [['shoes_id', 'brand_id', 'material_id', 'lining_id', 'color', 'sole_id', 'last_id'], 'integer'],
            [['appointment_left', 'shoes_data', 'brand_data', 'material_data', 'lining_data', 'color_data', 'appointment_left_data', 'appointment_right_data', 'heel_left_data', 'heel_right_data', 'sole_data', 'last_data', 'appointment_right', 'heel_left', 'heel_right'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'shoes_id' => 'Вид обуви',
            'brand_id' => 'Модель',
            'material_id' => 'Материал верха/цвет',
            'lining_id' => 'Подкладка',
            'color' => 'Цвет',
            'color_id' => 'Цвет',
            'appointment_left' => 'Назначение левая',
            'appointment_right' => 'Назначение правая',
            'heel_left' => 'Задник левая',
            'heel_right' => 'Задник правая',
            'sole_id' => 'Подошва',
            'last_id' => 'Колодка',


        ];
    }

    /**
     * @return array
     */
    public static function getOptions()
    {
        return [
            // материалы верха
            'material_id' => [
                1 => 'ХРОМ',
                2 => 'НУБУК',
                3 => 'ФЛОТЕР',
                4 => 'ПЕРФОРАЦИЯ',
            ],
            'color' => [
                1 => [
                    1,2,3,4,5,6,7,8,9,10
                ],
                2 => [
                    11,12,13,14,15,16,17,18,19,20
                ],
                3 => [
                    21,22,23,24,25,26,27,28,29,30
                ],
                4 => [
                    31,32,33,34,35,36,37,38,39,40
                ],
            ],
            // подкладки
            'lining_id' => [
                1 => 'МЕХ',
                2 => 'БАЙКА',
                3 => 'К/П',
            ],
            // подошвы
            'sole_id' => [
                1 => 'ЭВА',
                2 => 'КЕД /белая',
                3 => 'КЕД /чёрная',
                4 => 'МАРФА',
                5 => 'АГАТА',
                6 => 'МАРТИНСОН',
                7 => 'КРОСС/белая',
                8 => 'КРОСС/чёрная',
                9 => 'ПОДРОСТКОВАЯ/крэп',
                10 => 'МАРШЕ/крэп',
                11 => 'МАРШЕ/чёрная',
                12 => '3582',
                13 => '1719',
                14 => 'ВОЛД',
            ],
            // колодки
            'last_id' => [
                1 => 'КРОСС',
                2 => 'АТЛЕТИК',
                3 => 'МАРФА',
                4 => '0310',
                5 => 'ТАРОТ',
                6 => '811',
                7 => '805',
                8 => 'ТКед',
                9 => '247',
                10 => '3582',
                11 => 'КЕД',
                12 => 'КОМФОРТ',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getColorsArray()
    {
        $result = [];
        for($i = 1; $i <= 40; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }
    public function getModelBrand()
    {
        return $this->hasOne(ShoesBrand::className(), ['id' => 'brand_id']);
    }
    public function getModelMaterial()
    {
        return $this->hasOne(ShoesMaterial::className(), ['id' => 'material_id']);
    }
    public function getModelColor()
    {
        return $this->hasOne(ShoesColor::className(), ['id' => 'color_id']);
    }
    public function getModelLining()
    {
        return $this->hasOne(ShoesLining::className(), ['id' => 'lining_id']);
    }
    public function getModelSole()
    {
        return $this->hasOne(ShoesSole::className(), ['id' => 'sole_id']);
    }
    public function getModelLast()
    {
        return $this->hasOne(ShoesLast::className(), ['id' => 'last_id']);
    }

    public function getColorName()
    {
        if($this->modelColor) {
            return $this->modelColor->name;
        }
        return $this->color;
    }
    public function getColorDataName()
    {
        if($this->color_data) {
            return $this->getColorName()."<span>($this->color_data)</span>";
        }
        return $this->getColorName();
    }
    public function getModelName()
    {
        if($this->modelBrand) {
            return $this->modelBrand->name;
        }
        return $this->model;
    }
    public function getModelDataName()
    {
        if($this->brand_data) {
            return $this->getModelName()."<span>($this->brand_data)</span>";
        }
        return $this->getModelName();
    }





    public function getModelsList()
    {
        return ArrayHelper::map(ShoesModel::find()->asArray()->all(), 'id', 'name');
        return ArrayHelper::map(Shoes::find()->where(['not', ['parent_id' => null]])->all(), 'id', 'name');
    }
    public function getBrandList()
    {
        return ArrayHelper::map(ShoesBrand::find()->asArray()->all(), 'id', 'name');
        return ArrayHelper::map(Shoes::find()->where(['not', ['parent_id' => null]])->all(), 'id', 'name');
    }
    public function getLiningList()
    {
        return ArrayHelper::map(ShoesLining::find()->asArray()->all(), 'id', 'name');
    }
    public function getColorList()
    {
        return ArrayHelper::map(ShoesColor::find()->asArray()->all(), 'id', 'name');
    }
    public function getMaterialList()
    {
        return ArrayHelper::map(ShoesMaterial::find()->asArray()->all(), 'id', 'name');
    }
    public function getSoleList()
    {
        return ArrayHelper::map(ShoesSole::find()->asArray()->all(), 'id', 'name');
    }
    public function getLastList()
    {
        return ArrayHelper::map(ShoesLast::find()->asArray()->all(), 'id', 'name');
    }
    public static function uniqueAppointments($appointments)
    {
        if(!empty($appointments)) {
            $uniqueArray = [];
            $appointmentsArray = [];
            foreach($appointments as $appointment) {
                if(!in_array(trim($appointment['name']), $uniqueArray)) {
                    $appointmentsArray[] = $appointment;
                    $uniqueArray[] = trim($appointment['name']);
                }
            }
        }
        return $appointmentsArray;
    }
    public function appointmentArray()
    {
        if($appointment = Appointment::find()->asArray()->all()) {
            return ArrayHelper::map(self::uniqueAppointments($appointment), 'id', 'name');
        }
        return [];
    }

    public function appointmentLeftArray()
    {
        if($appointment = Appointment::find()->where(['side' => Appointment::SIDE_LEFT])->asArray()->all()) {
            return ArrayHelper::map($appointment, 'id', 'name');
        }
        return [];
    }
    public function appointmentRightArray()
    {
        if($appointment = Appointment::find()->where(['side' => Appointment::SIDE_RIGHT])->asArray()->all()) {
            return ArrayHelper::map($appointment, 'id', 'name');
        }
        return [];
    }
    public function heelArray()
    {
        if($appointment = ShoesHeel::find()->asArray()->all()) {
            return ArrayHelper::map(self::uniqueAppointments($appointment), 'id', 'name');
        }
        return [];
    }
    public function heelLeftArray()
    {
        return ArrayHelper::map(ShoesHeel::find()->where(['side' => ShoesHeel::SIDE_LEFT])->asArray()->all(), 'id', 'name');
    }
    public function heelRightArray()
    {
        return ArrayHelper::map(ShoesHeel::find()->where(['side' => ShoesHeel::SIDE_RIGHT])->asArray()->all(), 'id', 'name');
    }

    /**
     * @param $optionName
     * @return mixed|string
     */
    public function getOptionName($optionName)
    {
        $options = self::getOptions();
        return ($this->$optionName && array_key_exists($this->$optionName, $options[$optionName])) ? $options[$optionName][$this->$optionName] : '';
    }
    public function getOptionArray($optionName)
    {
        $options = self::getOptions();
        return array_key_exists($optionName, $options) ? $options[$optionName] : [];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoes()
    {
        return $this->hasOne(Shoes::className(), ['id' => 'shoes_id']);
    }
}
