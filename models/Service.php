<?php

namespace app\models;

use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "services".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Service extends BasePage
{
    public $image_field;
    public $image_fields = ['image_field' => 'image_id'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'services';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sortOrder',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            //[['content', 'short_description', 'anons_1', 'anons_2'], 'string'],
            [['content', 'short_description', 'anons_1', 'anons_2'], 'safe'],
            [['image_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image_field', 'sortOrder'], 'safe'],
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
            'content' => 'Контент',
            'anons_1' => 'Анонс 1',
            'anons_2' => 'Анонс 2',
            'image_id' => 'Изображение',
            'image_field' => 'Изображение',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }

    public static function getModels($limit = 6)
    {
        return Service::find()
            ->joinWith(['page'])
            ->where(['not', ['services.id' => 10]])
            ->orderBy(['pages.sortOrder' => SORT_ASC])
            ->limit($limit)
            ->all();
    }
}
