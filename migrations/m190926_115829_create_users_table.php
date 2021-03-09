<?php

use yii\db\Migration;

/**
 * m190926_115829_create_users_table
 */
class m190926_115829_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->char(64)->notNull()->unique(),
            'password' => $this->char(255)->notNull(),
            'password_reset_token' => $this->char(255)->unique(),
            'access_token' => $this->char(64),
            'auth_key' => $this->char(64),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('usersAccessToken', 'user', ['access_token'], true);
        $this->createIndex('usersLogin', 'user', ['login'], true);
        $this->createIndex('usersEmail', 'user', ['email'], true);

        $this->insert('user', [
            'id' => 1,
            'login' => 'root',
            'password' => '$2y$13$wZfTFKQLANy.OnqUhv0L/ubxwmDF/Xb3a3xCuqZTpkApA8eH3YY7G', // root
            'password_reset_token' => '',
            'access_token' => \Yii::$app->security->generateRandomString(),
            'auth_key' => null,
            'email' => 'example@example.com',
            'status' => 10,
            'created_at' => null,
            'updated_at' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
