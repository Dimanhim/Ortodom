<?php

namespace app\modules\directory\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use app\modules\directory\models\ShoesBase;

/**
 * This is the model class for table "shoes_materials".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShoesMaterial extends ShoesBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shoes_materials';
    }

    /**
     * @return array
     */
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
            [['color_ids', 'created_at', 'updated_at'], 'safe'],
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
            'color_ids' => 'Цвета',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function afterFind()
    {
        if($this->color_ids) {
            $this->color_ids = explode(',', $this->color_ids);
        }
        return parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if($this->color_ids) {
            $this->color_ids = implode(',', $this->color_ids);
        }
        return parent::beforeSave($insert);
    }

    public function getColors()
    {
        return $this->color_ids ? ShoesColor::find()->where(['in', 'id', $this->color_ids])->all() : false;
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }

    public function getColorsList()
    {
        if($colors = $this->colors) return ArrayHelper::map($this->colors, 'id', 'name');
        return [];
    }
}
