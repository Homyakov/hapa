<?php

namespace app\controllers;
use app\models\AccountChange;
use app\models\Categories;
use app\models\Comment;
use app\models\Comments;
use app\models\Login;
use app\models\User;
use app\models\Signup;
use yii\data\Pagination;
use app\models\Lessons;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;


class SiteController extends Controller
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


    public function actionIndex()
    {
        $categories = Categories::find()
            ->all();

        return $this->render('index',[
            'categories'=>$categories,
        ]);
    }

    public function actionCategory()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $category = Categories::find()
            ->select(['title'])
            ->where('id=:id',[':id'=>$get['id']])
            ->one();


        $query = Lessons::find()
            ->where('cat=:id',[':id'=>$get['id']]);



        $pagination = new Pagination([
            'defaultPageSize'=>4,
            'totalCount'=>$query->count(),
        ]);
        $lessons = $query->orderBy('data')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('category',[
            'category'=>$category,
            'lessons'=>$lessons,
            'pagination'=>$pagination,
        ]);
    }
f
    public function actionArticles()
    {
      if ( Yii::$app->request->post('search')){
          $otvet = Yii::$app->request->post('search');
          $lessons =Lessons::find()
              ->where(['like', 'text', $otvet])
              ->all();
          return $this->render('search',[
              'lessons'=>$lessons,
          ]);
      }
        $query = Lessons::find();

        $pagination = new Pagination([
            'defaultPageSize'=>4,
            'totalCount'=>$query->count(),
        ]);
        $lessons = $query->orderBy('data')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
      

        return $this->render('articles', [
            'lessons' => $lessons,
            'pagination'=>$pagination,
          
        ]);

    }


    public function actionPost()
    {

        $request = Yii::$app->request;
        $get = $request->get();
        $lessons = Lessons::find()
            ->select(['title','data','view','author','text','id','com'])
            ->where('id=:id',[':id'=>$get['id']])
            ->one();

        $comment_model = new Comment();

        if ( Yii::$app->request->post('Comment'))
        {
            if (!Yii::$app->user->isGuest) {
                $comment_model->attributes = Yii::$app->request->post('Comment');
                $comment_model->addComment();
                $lessons->updateCounters(['com' => 1]);
            }
            else {
                return $this->redirect(['account/login']);
            }
        }


        $comments = Comments::find()
            ->select(['author','date','text'])
            ->where('post=:id',[':id'=>$get['id']])
            ->all();
        $lessons->updateCounters(['view' => 1]);
        return $this->render('post',[
            'lessons'=>$lessons,
            'comment_model'=>$comment_model,
            'comments'=>$comments,
        ]);



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
