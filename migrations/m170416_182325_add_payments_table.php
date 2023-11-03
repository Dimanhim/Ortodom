<?php

use yii\db\Migration;

class m170416_182325_add_payments_table extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-payment-name', '{{%payments}}', ['name']);

        $this->batchInsert('{{%payments}}', ['name'], [
            ['ФСС'],
            ['КСП'],
            ['Н/р'],
            ['Возмещение'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%payments}}');
    }
}
