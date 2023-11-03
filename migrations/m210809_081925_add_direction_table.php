<?php

use yii\db\Migration;

class m210809_081925_add_direction_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%directions}}', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-directions-name', '{{%directions}}', ['name']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%directions}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210809_081925_add_direction_table cannot be reverted.\n";

        return false;
    }
    */
}
