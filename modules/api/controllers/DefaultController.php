<?php

namespace app\modules\api\controllers;

use app\models\Messages;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

//
//// Allow from any origin
//if (isset($_SERVER['HTTP_ORIGIN'])) {
//    // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
//    // whitelist of safe domains
//    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//    header('Access-Control-Allow-Credentials: true');
//    header('Access-Control-Max-Age: 86400');    // cache for 1 day
//}
//// Access-Control headers are received during OPTIONS requests
//if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//
//    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
//        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
//
//    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
//        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
//
//}

/**
 * Class DefaultController
 * @package app\modules\api\controllers
 */
class DefaultController extends Controller
{
    protected $mute = ['fuck', 'test', 'loh', 'лох', 'тест'];

    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

//        $behaviors['authenticator'] = [
//            'class' => CompositeAuth::class,
//            'authMethods' => [
//                HttpBasicAuth::class,
//                HttpBearerAuth::class,
//            ],
////            'optional' => ['index']
//            'except' => ['options','login'],
//        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['options','login','get'],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'get' => ['GET'],
                'send' => ['POST'],
                'update' => ['PUT'],
                'delete' => ['DELETE'],
            ]
        ];

        return $behaviors;
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        if (!\Yii::$app->user->can('user')) {
            throw new ForbiddenHttpException('Access denied');
        }

        if (\Yii::$app->user->isGuest) {
            return 'Welcome Guest';
        }
        return 'Welcome ' . \Yii::$app->user->identity->login;
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function actionGet($page = 0)
    {
        return new ActiveDataProvider([
            'query' => Messages::getAllPostsWithUserName(),
            'pagination' => [
//                'pageSize' => 2,
                'page' => $page
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);
    }

    /**
     * @return bool
     */
    public function actionSend()
    {
        $post = \Yii::$app->request->post();

        $model = new Messages(['user_id' => \Yii::$app->user->identity->getId()]);
        $model->setAttribute('show', 1);

        if (!empty($post['message'])) {
            foreach ($this->mute as $item) {
                if (preg_match("/$item/", $post['message'])) {
                    $model->setAttribute('show', 0);
                }
            }
        }

        if (!$model->load($post, '') || !$model->save()) {
            throw new \RuntimeException('Не удалось отправить сообщение');
        }
        return true;
    }

    /**
     * @param $id
     * @return bool
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $params = \Yii::$app->request->getBodyParams();

        if (!$model = Messages::findOne($id)) {
            throw new NotFoundHttpException('Не удалось найти запись');
        }

        if (!$model->load($params, '') || !$model->save()) {
            throw new \RuntimeException('Не удалось отредактировать сообщение');
        }
        return true;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if (!$model = Messages::findOne($id)) {
            throw new NotFoundHttpException('Не удалось найти запись');
        }

        if (!$model->delete()) {
            throw new \RuntimeException('Не удалось удалить сообщение');
        }
        return true;
    }
}
