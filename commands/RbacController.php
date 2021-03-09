<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // добавляем разрешение "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // добавляем разрешение "deletePost"
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'delete post';
        $auth->add($deletePost);

        // добавляем роль "user" и даём роли разрешение "createPost"
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createPost);

        // добавляем роль "admin" и даём роли разрешение "updatePost" и "deletePost"
        // а также все разрешения роли "user"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $deletePost);
        $auth->addChild($admin, $user);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId() в модели User.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }
}