<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160905_215953_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('words', [
            'id'            => Schema::TYPE_UPK,
            'title'         => Schema::TYPE_STRING . '(128) NOT NULL UNIQUE',
            'description'   => Schema::TYPE_TEXT,
            'rating'        => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'bad_word'      => 'TINYINT NOT NULL DEFAULT 1',
            'altcount'      => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'created_at'    => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at'    => Schema::TYPE_TIMESTAMP,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('words_alternatives', [
            'good_word_id'  => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'bad_word_id'   => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'PRIMARY KEY (good_word_id, bad_word_id)'
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('words');
        $this->dropTable('words_alternatives');
    }
}
