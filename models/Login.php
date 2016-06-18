<?php


namespace app\models;

use yii\base\Model;

class Login extends Model
{
    public $email;
    public $password;
    public $login;
    

    public function rules()
    {
        return [
        [ ['login','password'],'required'],
            ['password','validatePassword']
        ];
    }

    public function  validatePassword($attribute,$params)
    {
       $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->password))
        {
            $this->addError($attribute,'Пароль или логин введены неверно');
        }
    }

    public function getUser()
    {
        return User::findOne(['login'=>$this->login]);
    }
}