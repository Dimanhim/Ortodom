<?php

namespace app\modules\directory\models;

use app\models\Image;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shoes_colors".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShoesColor extends \yii\db\ActiveRecord
{
    public $images_field;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shoes_colors';
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
            [['images_field', 'images'], 'safe'],
            [['name', 'color'], 'string', 'max' => 255],
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
            'images_field' => 'Изображения',
            'images' => 'Изображения',
            'color' => 'Цвет',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function afterFind()
    {
        return parent::afterFind();
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    public function getImages()
    {
        if($colorImages = ColorImage::find()->select(['image_id'])->where(['color_id' => $this->id])->asArray()->all()) {
            $ids = array_map(function($a) {
                return $a['image_id'];
            }, $colorImages);
            return Image::find()->where(['in', 'id', $ids])->all();
        }
        return false;
    }

    public function getColorImages()
    {
        if($colorImages = ColorImage::find()->select(['image_id'])->where(['color_id' => $this->id])->asArray()->all()) {
            $imageIds = [];
            foreach($colorImages as $colorImage) {
                $imageIds[] = $colorImage['image_id'];
            }
            return Image::find()->where(['in', 'id', $imageIds])->all();
        }
        return false;
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }

    public function uploadImages()
    {
        if($this->images_field) {
            if($images = UploadedFile::getInstances($this, 'images_field')) {
                foreach ($images as $key => $image) {
                    $fileName = md5(time().$image->name);
                    $filePath = "/upload/color/{$fileName}.{$image->extension}";

                    if ($image->saveAs(Yii::getAlias('@webroot').$filePath)) {
                        $modelImage = new Image();
                        $modelImage->path = $filePath;
                        if($modelImage->save()) {
                            $color_image = new ColorImage();
                            $color_image->color_id = $this->id;
                            $color_image->image_id = $modelImage->id;
                            $color_image->save();
                        }
                    }
                }
            }
        }
        return true;
    }

    public function getColorHtml()
    {
        return $this->color ? '<span class="circle-colored" style="background-color: '.$this->color.'"></div>' : '';
    }
}
