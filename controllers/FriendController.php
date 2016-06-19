<?php


namespace app\controllers;

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
        $request = Yii::$app->request;
        $get = $request->get();
        $info_account = User::findOne(['login' => $get['login'] ]);

        return $this->render('profil', [
            'info_account' => $info_account,
        ]);
    }

}