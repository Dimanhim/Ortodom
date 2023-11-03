<?php

namespace app\models;

use app\modules\directory\models\OrderStatus;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_status_dates".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Orders $id0
 */
class OrderStatusDate extends \yii\db\ActiveRecord
{
    const TYPE_ACCEPTED = 1;  // Принят
    const TYPE_ISSUED   = 2;  // Выдан
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_status_dates';
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
            [['status_id'], 'required'],
            [['status_id', 'order_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'status_id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status_id']);
    }

    public function getStatusName()
    {
        return $this->status ? $this->status->name : false;
    }
}
