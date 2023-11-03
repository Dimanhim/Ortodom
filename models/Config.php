<?php

namespace app\models;

use app\modules\directory\models\Shoes;
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
class Config extends BaseOrder
{
    public $patient_id;
    public $addConfigOrder;
    public $addConfigNewPatient;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['shoes_id', 'brand_id', 'material_id', 'lining_id', 'color', 'sole_id', 'last_id', 'patient_id'], 'integer'],
            [['appointment_left', 'shoes_data', 'brand_data', 'material_data', 'lining_data', 'color_data', 'appointment_left_data', 'appointment_right_data', 'heel_left_data', 'heel_right_data', 'sole_data', 'last_data', 'appointment_right', 'heel_left', 'heel_right'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

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
            'appointment_left' => 'Назначение левая',
            'appointment_right' => 'Назначение правая',
            'heel_left' => 'Задник левая',
            'heel_right' => 'Задник правая',
            'sole_id' => 'Подошва',
            'last_id' => 'Колодка',

            'shoes_data' => 'Вписать допданные',
            'brand_data' => 'Вписать допданные',
            'material_data' => 'Вписать допданные',
            'lining_data' => 'Вписать допданные',
            'color_data' => 'Вписать допданные',
            'appointment_left_data' => 'Вписать допданные',
            'appointment_right_data' => 'Вписать допданные',
            'heel_left_data' => 'Вписать допданные',
            'heel_right_data' => 'Вписать допданные',
            'sole_data' => 'Вписать допданные',
            'last_data' => 'Вписать допданные',

            'patient_id' => 'Пациент'
        ];
    }

    /**
     * @return string
     */
    public function modelImage()
    {
        return '/images/ortodom.png';
    }

    /**
     * @return string
     */
    public function modelImageBlock()
    {
        return '
            <div class="ready-model-photo">
                <img src="'.$this->modelImage().'" alt="" />
            </div>
        ';
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }
}
