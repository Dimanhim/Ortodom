<?php

namespace app\modules\directory\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\Image;

/**
 * This is the model class for table "brand_color_images".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property integer $color_id
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Images $image
 */
class BrandColorImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand_color_images';
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
            [['brand_id', 'color_id', 'image_id'], 'required'],
            [['brand_id', 'color_id', 'image_id', 'position'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Модель',
            'color_id' => 'Цвет',
            'image_id' => 'Изображение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    public function getBrand()
    {
        return $this->hasOne(ShoesBrand::className(), ['id' => 'brand_id']);
    }

    public function getColor()
    {
        return $this->hasOne(ShoesColor::className(), ['id' => 'color_id']);
    }
}
