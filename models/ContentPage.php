<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_pages".
 *
 * @property int $id
 * @property string $name
 * @property int|null $image_id
 * @property string|null $content
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Image $image
 */
class ContentPage extends BasePage
{
    public $image_field;
    public $image_fields = ['image_field' => 'image_id'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['image_id'], 'integer'],
            [['content', 'short_description', 'anons_1', 'anons_2'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['image_field', 'user_date'], 'safe'],
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
            'short_description' => 'Короткое описание',
            'content' => 'Контент',
            'anons_1' => 'Анонс 1',
            'anons_2' => 'Анонс 2',
            'image_id' => 'Изображение',
            'image_field' => 'Изображение',
            'user_date' => 'Пользовательская дата',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function afterFind()
    {
        if($this->user_date) {
            $this->user_date = date('d.m.Y', $this->user_date);
        }
        return parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if($this->user_date) {
            $this->user_date = strtotime($this->user_date);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}
