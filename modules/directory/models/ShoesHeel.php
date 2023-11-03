<?php

namespace app\modules\directory\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "shoes_heels".
 *
 * @property integer $id
 * @property string $name
 * @property integer $side
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShoesHeel extends \yii\db\ActiveRecord
{
    const SIDE_LEFT = 1;
    const SIDE_RIGHT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shoes_heels';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['side'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'side' => 'Сторона',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
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
