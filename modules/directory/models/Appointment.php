<?php

namespace app\modules\directory\models;

use Yii;

/**
 * This is the model class for table "appointments".
 *
 * @property integer $id
 * @property string $name
 */
class Appointment extends \yii\db\ActiveRecord
{
    const SIDE_LEFT = 1;
    const SIDE_RIGHT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appointments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['side', 'integer'],
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
            'side' => 'Сторона',
        ];
    }

    /**
     * @return array
     */
    public function getSideArray()
    {
        return [
            self::SIDE_LEFT => 'Левая',
            self::SIDE_RIGHT => 'Правая',
        ];
    }

    /**
     * @return bool
     */
    public function getSideName()
    {
        return $this->side ? $this->sideArray[$this->side] : false;
    }
}
