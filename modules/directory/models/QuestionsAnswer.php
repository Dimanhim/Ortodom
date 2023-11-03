<?php

namespace app\modules\directory\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "questions_answers".
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property integer $created_at
 * @property integer $updated_at
 */
class QuestionsAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions_answers';
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
            [['sortOrder'], 'integer'],
            [['question', 'answer'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'sortOrder' => 'Сортировка',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Updated At',
        ];
    }
}
