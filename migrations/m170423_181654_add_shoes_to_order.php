<?php

use app\models\Order;
use app\models\Patient;
use app\modules\directory\models\Diagnosis;
use app\modules\directory\models\Payment;
use app\modules\directory\models\Shoes;
use yii\db\Migration;

class m170423_181654_add_shoes_to_order extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->dropForeignKey('orders_payments', Order::tableName());
        $this->dropForeignKey('orders_diagnosis', Order::tableName());
        $this->dropForeignKey('orders_patients', Order::tableName());

        $this->dropIndex('fx-orders', Order::tableName());
        $this->dropIndex('idx-orders', Order::tableName());

        $this->dropColumn(Order::tableName(), 'kind_of_shoes');
        $this->addColumn(Order::tableName(), 'shoes_id', $this->integer(11)->after('referral'));

        $this->addForeignKey('orders_payments', Order::tableName(), 'payment_id', Payment::tableName(), 'id');
        $this->addForeignKey('orders_diagnosis', Order::tableName(), 'diagnosis_id', Diagnosis::tableName(), 'id');
        $this->addForeignKey('orders_patients', Order::tableName(), 'patient_id', Patient::tableName(), 'id');

        $this->addForeignKey('orders_shoes', Order::tableName(), 'shoes_id', Shoes::tableName(), 'id');
        $this->createIndex('fx-orders', Order::tableName(), ['payment_id', 'diagnosis_id', 'patient_id', 'shoes_id']);
        $this->createIndex('idx-orders', Order::tableName(), ['representative_name', 'referral', 'accepted', 'issued', 'prepaid', 'cost']);
    }

    public function safeDown()
    {
        $this->dropForeignKey('orders_payments', Order::tableName());
        $this->dropForeignKey('orders_diagnosis', Order::tableName());
        $this->dropForeignKey('orders_patients', Order::tableName());
        $this->dropForeignKey('orders_shoes', Order::tableName());

        $this->dropIndex('fx-orders', Order::tableName());
        $this->dropIndex('idx-orders', Order::tableName());

        $this->dropColumn(Order::tableName(), 'shoes_id');
        $this->addColumn(Order::tableName(), 'kind_of_shoes', $this->string(255)->after('referral'));

        $this->addForeignKey('orders_payments', Order::tableName(), 'payment_id', Payment::tableName(), 'id');
        $this->addForeignKey('orders_diagnosis', Order::tableName(), 'diagnosis_id', Diagnosis::tableName(), 'id');
        $this->addForeignKey('orders_patients', Order::tableName(), 'patient_id', Patient::tableName(), 'id');

        $this->createIndex('fx-orders', Order::tableName(), ['payment_id', 'diagnosis_id', 'patient_id']);
        $this->createIndex('idx-orders', Order::tableName(), ['representative_name', 'referral', 'kind_of_shoes', 'accepted', 'issued', 'prepaid', 'cost']);
    }
}
