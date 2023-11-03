<?php

use app\models\Patient;
use app\modules\directory\models\Diagnosis;
use app\modules\directory\models\Payment;
use yii\db\Migration;

class m170417_172529_add_orders_table extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(11),
            'patient_id' => $this->integer(11)->notNull(),
            'representative_name' => $this->string(255),
            'payment_id' => $this->integer(11),
            'diagnosis_id' => $this->integer(11),
            'referral' => $this->string(255),
            'kind_of_shoes' => $this->string(255),
            'accepted' => $this->date()->notNull(),
            'issued' => $this->date(),
            'prepaid' => $this->decimal(10),
            'cost' => $this->decimal(10),

            'model' => $this->string(255),
            'color' => $this->string(255),
            'size'  => $this->string(255),
        ], $tableOptions);

        $this->addForeignKey('orders_payments', '{{%orders}}', 'payment_id', Payment::tableName(), 'id');
        $this->addForeignKey('orders_diagnosis', '{{%orders}}', 'diagnosis_id', Diagnosis::tableName(), 'id');
        $this->addForeignKey('orders_patients', '{{%orders}}', 'patient_id', Patient::tableName(), 'id');

        $this->createIndex('fx-orders', '{{%orders}}', ['payment_id', 'diagnosis_id', 'patient_id']);
        $this->createIndex('idx-orders', '{{%orders}}', ['representative_name', 'referral', 'kind_of_shoes', 'accepted', 'issued', 'prepaid', 'cost']);
    }

    public function safeDown()
    {
        $this->dropForeignKey('orders_payments', '{{%orders}}');
        $this->dropForeignKey('orders_diagnosis', '{{%orders}}');
        $this->dropForeignKey('orders_patients', '{{%orders}}');

        $this->dropTable('{{%orders}}');
    }
}
