<?php

namespace app\modules\directory\models;

use app\models\Image;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "partners".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Partner extends \yii\db\ActiveRecord
{
    public $image_field;
    public $image_fields = ['image_field' => 'image_id'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners';
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
            [['description'], 'string'],
            [['image_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image_field'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Описание',
            'image_id' => 'Изображение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'image_field' => 'Изображение',
        ];
    }

    public function beforeSave($insert)
    {
        $this->uploadImage();
        return parent::beforeSave($insert);
    }

    public function uploadImage()
    {
        $filesDir = Yii::getAlias('@webroot')."/upload/partners/";
        if (!file_exists($filesDir)) mkdir($filesDir, 0777, true);
        foreach ($this->image_fields as $image_field => $image_fieldName) {
            if ($file = UploadedFile::getInstance($this, $image_field)) {
                $fileName = md5(time().$image_fieldName);
                $filePath = "/upload/partners/{$fileName}.{$file->extension}";

                if (!$file->saveAs(Yii::getAlias('@webroot').$filePath)) {
                    continue;
                }

                if ($this->$image_fieldName and $existingImage = Image::findOne($this->$image_fieldName)) {
                    $existingImage->delete();
                }

                if ($image = Image::create($filePath)) {
                    $this->$image_fieldName = $image->id;
                }
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}
