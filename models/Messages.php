<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Messages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%messages}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['id', 'user_id', 'created_at', 'updated_at', 'show'], 'integer'],
        ];
    }

    /**
     * Finds message by id
     *
     * @param int $id
     * @return static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds message by user_id
     *
     * @param int $userId
     * @return Messages[]
     */
    public static function findByUserId($userId)
    {
        return static::findAll(['user_id' => $userId]);
    }

    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllPostsWithUserName()
    {
        return self::find()
            ->where(['show' => 1])
            ->join('left join', 'user', 'user.id = messages.user_id')
            ->select(['messages.id', 'message', 'show', 'login'])
            ->asArray();
    }
}
