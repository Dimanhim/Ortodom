<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace app\models;

use app\components\Helpers;

/**
 * This is the model class for table "patients".
 *
 * @property int $id
 * @property string $full_name
 * @property string $birthday
 * @property string $address
 * @property string $phone
 * @property string $passport_data
 * @property int $created_at
 */
class Patient extends \yii\db\ActiveRecord
{
    // true - не создавать заказ
    public $insert_order = false;

    /*public function __construct($insert_order = false)
    {
        $this->insert_order = $insert_order;
    }*/
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'birthday', 'address', 'phone', 'passport_data'], 'required'],
            [['birthday'], 'safe'],
            [['passport_data'], 'string'],
            [['created_at', 'problem'], 'integer'],
            [['full_name', 'address', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'birthday' => 'Дата рождения',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'passport_data' => 'Паспортные данные пациента (представителя)',
            'problem' => 'Проблемный пациент',
            'created_at' => 'Добавлен',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();

        //$this->birthday = date('d.m.Y', strtotime($this->birthday));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['patient_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
            }

            $this->birthday = date('Y-m-d', strtotime($this->birthday));

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert && !$this->insert_order) {
            $order = new Order();
            $order->patient_id = $this->id;
            $order->accepted = date('Y-m-d');
            $order->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->orders as $order) {
                $order->delete();
            }

            return true;
        }

        return false;
    }
    public function isPaymentInOrder($payment)
    {
        foreach($this->orders as $order) {
            if($order->payment_id == $payment) return true;
        }
        return false;
    }

    public function getFullName()
    {
        return $this->problem ? $this->full_name . Helpers::$_problem_sign : $this->full_name;
    }
}
