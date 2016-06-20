<?php


namespace app\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

class AccountChange extends Model
{

    public $login;
    public $email;
    public $name;
    public $lastname;
    public $fathername;
    public $date;
    public $aboutme;
    public $imageFile;
    public $answer;



   public function rules()
    {
        return [
            [['name','lastname','fathername','date','aboutme'],'safe'],
            [ ['email','login'],'required','message'=>'Заполните все поля'],
                ['login', 'match', 'pattern' => '/^[a-z]\w*$/i','message'=>'Логин должен начинаться с буквы и содержать только буквенные символы,числовые символы и знак подчеркивания'],
                ['email','email'],
                [['email','login'],'trim'],
                [['email','login'],'filter', 'filter' => 'stripslashes', 'skipOnArray' => true],
                [['email','login'],'filter', 'filter' => 'htmlspecialchars', 'skipOnArray' => true],
            [['imageFile'],'file',/*'skipOnEmpty'=>false,*/'extensions'=>['png','jpg'],'maxSize'=>1024*6024],

        ];
    }





public function save_account()
{
    $user =User::findOne([
        'login'=>Yii::$app->user->identity->login
    ]);
        if($this->imageFile->baseName !== NULL && $this->imageFile->extension !==NULL) {
            $this->imageFile->saveAs('uploads/'.$this->imageFile->baseName.'.'.$this->imageFile->extension);
            $user->imageFile = '../uploads/'.$this->imageFile->name;
            }



    $user->login = $this->login;
    $user->email = $this->email;
    $user->name = $this->name;
    $user->lastname = $this->lastname;
    $user->fathername = $this->fathername;
    $user->date = $this->date;
    $user->aboutme = $this->aboutme;
    return $user->save();
}


}