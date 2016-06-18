<?php
/**
 * Created by PhpStorm.
 * User: VsDragon
 * Date: 12.05.2016
 * Time: 11:28
 */

namespace app\models;


use yii\base\Model;

class Signup extends Model
{
    public $email;
    public $password;
    public $login;
    public $password_repeat;
    public $verifyCode;

    public function rules()
    {
        return [
            [['email','password','login','password_repeat'],'required','message'=>'Заполните поле'],
            ['login', 'match', 'pattern' => '/^[a-z]\w*$/i','message'=>'Логин должен начинаться с буквы и содержать только буквенные символы,числовые символы и знак подчеркиванияэ'],
            ['email','email'],
            ['login','unique','targetClass'=>'app\models\User','message'=>'Такой логин уже используется'],
            ['email','unique','targetClass'=>'app\models\User','message'=>'Такой email уже используется'],
            ['password','string','min'=>6,'message'=>'Пароль должен содержать не менее 6 символов'],
            ['password','compare','message'=>'Пароли не совпадают'],
            ['verifyCode', 'captcha'],
            [['email','password','login'],'trim'],
            [['email','password','login'],'filter', 'filter' => 'stripslashes', 'skipOnArray' => true],
            [['email','password','login'],'filter', 'filter' => 'htmlspecialchars', 'skipOnArray' => true],


        ];
    }

    public function signup()
    {
        $user = new User();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->setPassword($this->password);
        return $user->save();
    }
    public function getUser()
    {
        return User::findOne(['login'=>$this->login]);
    }
}