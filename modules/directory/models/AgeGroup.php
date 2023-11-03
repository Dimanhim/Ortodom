<?php

namespace app\modules\directory\models;

use app\models\Page;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age_groups".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class AgeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'age_groups';
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
            [['name'], 'string', 'max' => 255],
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
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }

    public static function relationsBrands()
    {
        return [
            Page::CHILD_SHOES_ID => 1,
            Page::TEENAGER_SHOES_ID => 2,
            Page::MAN_SHOES_ID => 3,
            Page::WOMAN_SHOES_ID => 4,
        ];
    }

    public static function ageGroupPageIds()
    {
        return [
            Page::CHILD_SHOES_ID,
            Page::TEENAGER_SHOES_ID,
            Page::MAN_SHOES_ID,
            Page::WOMAN_SHOES_ID,
        ];
    }

}
