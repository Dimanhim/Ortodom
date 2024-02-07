<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "patient_representatives".
 *
 * @property integer $id
 * @property integer $patient_id
 * @property string $name
 * @property string $passport_data
 * @property integer $created_at
 * @property integer $updated_at
 */
class PatientRepresentative extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_representatives';
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
            [['patient_id'], 'required'],
            [['patient_id', 'created_at', 'updated_at'], 'integer'],
            [['passport_data'], 'string'],
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
            'patient_id' => 'Patient ID',
            'name' => 'ФИО',
            'passport_data' => 'Паспортные данные',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }
    public function getRepresentativeHtml()
    {
        return Yii::$app->controller->renderPartial('_representative_form', [
            'model' => $this->patient,
        ]);
    }
    public function getRepresentativeFormHtml()
    {
        return Yii::$app->controller->renderPartial('_representative_edit_form', [
            'model' => $this,
        ]);
    }
}
