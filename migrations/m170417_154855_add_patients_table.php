<?php

use yii\db\Migration;

class m170417_154855_add_patients_table extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%patients}}', [
            'id' => $this->primaryKey(11),
            'full_name' => $this->string(255)->notNull(),
            'birthday' => $this->date()->notNull(),
            'address' => $this->string(255)->notNull(),
            'phone' => $this->string(255)->notNull(),
            'passport_data' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-patients', '{{%patients}}', ['full_name', 'birthday', 'address', 'phone', 'created_at']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%patients}}');
    }
}
