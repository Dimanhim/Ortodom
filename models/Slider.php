<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "sliders".
 *
 * @property integer $id
 * @property integer $banner_img_bg_id
 * @property integer $banner_img_id
 * @property integer $banner_info_img_id
 * @property string $title
 * @property string $name
 * @property string $sub_name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Slider extends \yii\db\ActiveRecord
{
    private $_upload_attributes = [
        'banner_img_bg_id', 'banner_img_id', 'banner_info_img_id',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sliders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_img_bg_id', 'banner_img_id', 'banner_info_img_id'], 'file'],
            [['title', 'name', 'sub_name'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_img_bg_id' => 'Бэкграунд',
            'banner_img_id' => 'Изображение',
            'banner_info_img_id' => 'Изображение info',
            'title' => 'Заголовок',
            'name' => 'Название',
            'sub_name' => 'Доп. название',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackgroundImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'banner_img_bg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'banner_img_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageInfo()
    {
        return $this->hasOne(Image::className(), ['id' => 'banner_info_img_id']);
    }

    public function uploadImages($oldAttributes = null)
    {
        if($attributes = $this->_upload_attributes) {
            foreach($attributes as $attribute) {
                if($image = UploadedFile::getInstance($this, $attribute)) {
                    $fileName = md5(time().$image->name);
                    $filePath = "/upload/sliders/{$fileName}.{$image->extension}";

                    if ($image->saveAs(Yii::getAlias('@webroot').$filePath)) {
                        $modelImage = Image::create($filePath);
                        $this->$attribute = $modelImage->id;
                        $this->save();
                    }
                }
                else {
                    if(array_key_exists($attribute, $oldAttributes)) {
                        $this->$attribute = $oldAttributes[$attribute];
                    }
                }
            }
        }

    }
}
