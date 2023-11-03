<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "galleries".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GalleryImage $image
 * @property GalleryImage[] $images
 */
class Gallery extends \yii\db\ActiveRecord
{
    public $images_field;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galleries';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_name'], 'required'],
            [['name', 'short_name'], 'string', 'max' => 255],
            ['images_field', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'short_name' => 'Короткое название',
            'images_field' => 'Изображения',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(GalleryImage::className(), ['gallery_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['gallery_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return bool
     */
    public function uploadImages()
    {
        $images_dir = Yii::getAlias('@frontend').'/web/upload/galleries/'.$this->id;
        if (!file_exists($images_dir)) mkdir($images_dir, 0777, true);
        $images = UploadedFile::getInstances($this, 'images_field');
        foreach ($images as $key => $image) {
            $image_path = '/web/upload/galleries/'.$this->id.'/'.$key.'.'.$image->extension;
            if ($image->saveAs(Yii::getAlias('@frontend').$image_path)) {
                $place_image = new GalleryImage();
                $place_image->gallery_id = $this->id;
                $place_image->path = $image_path;
                $place_image->position = $key;
                $place_image->save();
            }
        }
        return true;
    }
}
