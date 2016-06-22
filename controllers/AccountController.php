<?php

namespace app\controllers;
use app\models\AccountChange;
use app\models\Lessons;
use app\models\Login;
use app\models\User;
use app\models\Signup;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Comments;




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
                Yii::$app->session->setFlash("success",'Ваши данные успешно сохранены!');

                return $this->redirect(['index']);
            }
            return $this->redirect(['change']);
        }
    }

    public function actionIndex()
    {

        $info_account = User::findOne(['login'=>Yii::$app->user->identity->login]);

        $comments = Comments::find()
            ->where(['answer'=>Yii::$app->user->identity->login,
                'viewed'=>1])
        ->all();

        $posts=[];
        foreach($comments as $key=>$val) {
            $posts[] = $val->post;
        }

        $lessons_title = Lessons::find()
            ->select(['title','id'])
            ->where(['id'=> $posts])
            ->all();





        return $this->render('account', [
            'info_account' => $info_account,
            'comments' => $comments,
            'lessons_title' => $lessons_title,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('../site/index');
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