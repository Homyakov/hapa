<?php

namespace app\controllers;
use app\models\AccountChange;
use app\models\Login;
use app\models\User;
use app\models\Signup;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

;


class AccountController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionSignup()
    {
        $model = new Signup();

        if (isset($_POST['Signup'])) {
            $model->attributes = Yii::$app->request->post('Signup');

            if ($model->validate() && $model->signup()) {
                Yii::$app->user->login($model->getUser());
                return $this->redirect('../site/index');
            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionChange()
    {
        $account_change = new AccountChange();
        return $this->render('account_change', [
            'account_change' => $account_change,

        ]);
    }

    public function actionSave()
    {
        if (!empty(Yii::$app->request->post('AccountChange'))) {
            $account_change = new AccountChange();


            $account_change->attributes = Yii::$app->request->post('AccountChange');
            $account_change->date = Yii::$app->request->post('date');
            $account_change->imageFile = UploadedFile::getInstance($account_change,'imageFile');

            if ($account_change->validate() && $account_change->save_account()) {
                return $this->redirect(['index']);
            }
            return $this->redirect(['change']);
        }
    }

    public function actionIndex()
    {

        $info_account = User::findOne(['login' => Yii::$app->user->identity->login]);
        //var_dump($info_account->imagnFile);die;

        return $this->render('account', [
            'info_account' => $info_account,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $login_model = new Login();

        if (Yii::$app->request->post('Login')) {
            $login_model->attributes = Yii::$app->request->post('Login');


            if ($login_model->validate()) {
                Yii::$app->user->login($login_model->getUser());
                return $this->redirect('../site/index');
            }

        }
        return $this->render('login', ['login_model' => $login_model]);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->redirect('../site/index');
        }
    }


}