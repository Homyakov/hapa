<?php

namespace app\controllers;
use app\models\Categories;
use app\models\Comment;
use app\models\Comments;
use app\models\User;
use yii\data\Pagination;
use app\models\Lessons;
use Yii;
use yii\web\Controller;




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

    public function actionArticles()
    {

      if ( Yii::$app->request->post('search')){
          $otvet = Yii::$app->request->post('search');
          $lessons = Lessons::find()
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
        $lesson = Lessons::find()
            ->select(['title','data','view','author','text','id','com'])
            ->where('id=:id',[':id'=>$get['id']])
            ->one();

        $comment_model = new Comment();

        if ( Yii::$app->request->post('Comment'))
        {
            if (!Yii::$app->user->isGuest) {
                if(isset($get['answer']) && isset($get['com_id'])) {
                    $comment_model->answer = Yii::$app->user->identity->login;

                }

                $comment_model->attributes = Yii::$app->request->post('Comment');
                if ($comment_model->validate() && $comment_model->addComment()) {
                    if (!empty($comment_model->answer)) {

                        Yii::$app->session->setFlash("info",'Ваш ответ был успешно отправлен пользователю '.$get['answer']);
                    }
                    $lesson->updateCounters(['com' => 1]);
                }
            } else {
                return $this->redirect(['account/login']);
            }
        }

        $comments = Comments::find()
            ->select(['author','date','text','id'])
            ->where('post=:id',[':id'=>$get['id']])
            ->all();

        $lesson->updateCounters(['view' => 1]);


        if(isset($get['answer']) && isset($get['com_id'])) {
            $answer = $_GET['answer'].', ';
        }

        return $this->render('post',[
            'lesson'=>$lesson,
            'comment_model'=>$comment_model,
            'comments'=>$comments,
            'answer' => $answer
        ]);

    }



    
}
