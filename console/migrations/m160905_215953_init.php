<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160905_215953_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('words', [
            'id'            => Schema::TYPE_PK,
            'content'       => Schema::TYPE_STRING . '(128) NOT NULL ',
            'created_at'    => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'    => Schema::TYPE_INTEGER . ' NOT NULL',
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('words');
    }
}
