<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_description
 * @property string $anons_1
 * @property string $anons_2
 * @property string $content
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends BasePage
{
    public $image_field;
    public $image_fields = ['image_field' => 'image_id'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
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
            [['short_description', 'anons_1', 'anons_2', 'content'], 'string'],
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
            'name' => 'Название',
            'short_description' => 'Короткое описание',
            'anons_1' => 'Анонс 1',
            'anons_2' => 'Анонс 2',
            'content' => 'Контент',
            'image_id' => 'Изображение',
            'image_field' => 'Изображение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}
