<?php

namespace app\controllers;
use app\models\AccountChange;
use app\models\Dialogs;
use app\models\Lessons;
use app\models\Login;
use app\models\Message;
use app\models\User;
use app\models\Signup;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Comments;
use yii\data\Pagination;
use app\models\MessageForm;




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
                ->orderBy('id DESC')
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

    public function actionDialog(){
        if(!Yii::$app->user->isGuest) {

            $query = Dialogs::find();

            $login = Yii::$app->user->identity->login;

            $pagination = new Pagination([
                'defaultPageSize'=>8,
                'totalCount'=>$query->count(),
            ]);
            $dialogs = $query->where(['or',
                'pol1=:login',
                'pol2=:login',
            ])
                ->addParams([':login' => $login])
                ->orderBy('date DESC')
                ->orderBy('time DESC')
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        

           
            

            $message = Message::find()
                ->where(['or',
                    'komy=:login',
                    'ot_kovo=:login',
                ])
                ->addParams([':login' => $login])
                ->orderBy('id DESC')
                ->all();



            return $this->render('dialogs', [
                'dialogs' => $dialogs,
                'pagination'=>$pagination,
                'message'=>$message,

            ]);

        }

        return $this->goHome();
    }

    public function actionMessage(){
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


        $login = Yii::$app->request->get('login');
        $messages = Message::find()
            ->where(['or',
                ['and',
                'ot_kovo=:my_login',
                'komy=:his_login'],
                ['and',
                 'ot_kovo=:his_login',
                 'komy=:my_login']
            ])
            ->addParams([':my_login'=>Yii::$app->user->identity->login])
            ->addParams([':his_login'=>$login])
            ->orderBy('date')
            ->orderBy('time')
            ->all();

        return $this->render('message',[
            'messages'=>$messages,
            'info_account' => $info_account,
            'model_message'=>$model_message,
        ]);

    }






}