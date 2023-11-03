<?php

namespace app\modules\directory\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "brand_colors".
 *
 * @property integer $id
 * @property integer $color_id
 * @property integer $brand_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class BrandColor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand_colors';
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
            [['color_id', 'brand_id'], 'required'],
            [['color_id', 'brand_id', 'material_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_id' => 'Color ID',
            'brand_id' => 'Brand ID',
            'material_id' => 'Material ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
