<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page_relations".
 *
 * @property int $id
 * @property int $page_id
 * @property int $related_id
 * @property int $created_at
 * @property int $updated_at
 */
class PageRelation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_relations';
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
            [['page_id', 'related_id'], 'required'],
            [['page_id', 'related_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'related_id' => 'Related ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
    public function getPage()
    {
        return $this->hasOne(Page::class, ['id' => 'related_id']);
    }
}
