<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $email;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'string','min'=>6],
            ['email', 'email'],
        ];
    }

    public function Signup()
    {
        $user=new User();
        $user->username=$this->username;
        $user->password=\Yii::$app->getSecurity()->generatePasswordHash($this->password);
        //$hash = Yii::$app->getSecurity()->generatePasswordHash($password);
        $user->email=$this->email;
        $user->authKey=\Yii::$app->getSecurity()->generateRandomString();
        $user->accessToken=\Yii::$app->getSecurity()->generateRandomString();

        return $user->save();
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }



}