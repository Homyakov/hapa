<?php


namespace app\controllers;


use app\models\MessageForm;
use Yii;
use yii\web\Controller;
use app\models\User;


class FriendController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionProfil(){
        $model_message = new MessageForm();
        $request = Yii::$app->request;
        $get = $request->get();
        $info_account = User::findOne(['login' => $get['login'] ]);

        if (Yii::$app->request->post('MessageForm')){
            $model_message->attributes = Yii::$app->request->post('MessageForm');
           

            $found = $model_message->found_dialog();
            if ($found){
                $model_message->updateDate();
                $model_message->addMessage();
            }
            else {
                $model_message->addDialog();
                $model_message->addMessage();
            }


        }

        return $this->render('profil', [
            'info_account' => $info_account,
            'model_message'=>$model_message,
        ]);
    }



}