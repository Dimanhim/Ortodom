<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $path
 * @property string|null $title
 * @property string|null $alt
 * @property string|null $link
 * @property int $position
 * @property int $created_at
 * @property int $updated_at
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
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
     * @return bool
     */
    public function beforeDelete()
    {
        if (file_exists(Yii::getAlias('@webroot').$this->path)) {
            unlink(Yii::getAlias('@webroot').$this->path);
        }
        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['position'], 'integer'],
            [['path', 'title', 'alt', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'title' => 'Title',
            'alt' => 'Alt',
            'link' => 'Link',
            'position' => 'Position',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param string $path
     * @return Image
     */
    public static function create($path) {
        $image = new self();
        $image->path = $path;
        $image->save();
        return $image;
    }

    public function getPreviewsHtml()
    {
        return Yii::$app->controller->renderPartial('//chunks/_preview_img', [
            'image' => $this,
        ]);
    }

    public function getPreviewHtml()
    {
        return Yii::$app->controller->renderPartial('//chunks/_each_preview_img', [
            'image' => $this,
        ]);
    }
}
