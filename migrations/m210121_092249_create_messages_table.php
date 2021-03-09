<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m210121_092249_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'show' => $this->tinyInteger(1)->defaultValue(0),
        ]);

        $this->insert('{{%messages}}', [
            'message' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod',
            'user_id' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'show' => 1,
        ]);

        $this->insert('{{%messages}}', [
            'message' => 'tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,',
            'user_id' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'show' => 1,
        ]);

        $this->insert('{{%messages}}', [
            'message' => 'quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
            'user_id' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'show' => 1,
        ]);

        $this->insert('{{%messages}}', [
            'message' => 'consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse',
            'user_id' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'show' => 1,
        ]);

        $this->insert('{{%messages}}', [
            'message' => 'cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non',
            'user_id' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'show' => 1,
        ]);

        $this->insert('{{%messages}}', [
            'message' => 'proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'user_id' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'show' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
    }
}
