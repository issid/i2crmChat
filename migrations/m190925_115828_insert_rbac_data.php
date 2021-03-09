<?php

use yii\db\Migration;

/**
 * m190925_115828_insert_rbac_data
 */
class m190925_115828_insert_rbac_data extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->insert('auth_item', [
            'name' => 'admin',
            'type' => 1,
            'description' => null,
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('auth_item', [
            'name' => 'createPost',
            'type' => 2,
            'description' => 'Create a post',
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('auth_item', [
            'name' => 'deletePost',
            'type' => 2,
            'description' => 'Delete post',
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('auth_item', [
            'name' => 'updatePost',
            'type' => 2,
            'description' => 'Update post',
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('auth_item', [
            'name' => 'user',
            'type' => 1,
            'description' => null,
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('auth_assignment', ['item_name' => 'admin', 'user_id' => 1, 'created_at' => time(),]);

        $this->insert('auth_item_child', ['parent' => 'user', 'child' => 'createPost']);
        $this->insert('auth_item_child', ['parent' => 'admin', 'child' => 'deletePost']);
        $this->insert('auth_item_child', ['parent' => 'admin', 'child' => 'updatePost']);
        $this->insert('auth_item_child', ['parent' => 'admin', 'child' => 'user']);
    }
}
