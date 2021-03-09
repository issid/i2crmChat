<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class SignupForm
 * @package app\models
 */
class SignupForm extends Model
{
    public $login;
    public $password;
    public $email;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login', 'password', 'email'], 'required'],
            [['email'], 'email'],
            [['email'], 'validateEmailUnique'],
        ];
    }

    /**
     * Email checker
     * @param $attribute
     * @param $params
     */
    public function validateEmailUnique($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUserByEmail();

            if ($user) {
                $this->addError($attribute, 'Email already exists.');
            }
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUserByEmail()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    /**
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->login = $this->login;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);

            // Добавляем права доступа уровня пользователь
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());

            return $user;
        }

        return null;
    }
}
