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
use Yii\helpers\Url;





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
        $pagination->pageSizeParam = false;
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

        $query = Lessons::find();

        $pagination = new Pagination([
            'defaultPageSize'=>4,
            'totalCount'=>$query->count(),
        ]);
        $lessons = $query

            ->orderBy('data')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();




        return $this->render('articles', [
            'lessons' => $lessons,
            'pagination'=>$pagination,
          
        ]);

    }

    public function actionSearch()
    {

        $request = Yii::$app->request;
        $get = $request->get();
        if ( $get['search']){
            $query = Lessons::find()
                ->where(['like', 'text', $get['search']])
                ->orWhere(['like' ,'title', $get['search']])
                ->orWhere(['like' ,'meta_k', $get['search']])
                ->orWhere(['like' ,'meta_d', $get['search']]);


            $pagination = new Pagination([
                'defaultPageSize'=>4,
                'totalCount'=>$query->count(),
            ]);
            $lessons = $query
                ->orderBy('data')
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            return $this->render('search',[
                'lessons'=>$lessons,
                'pagination'=>$pagination,
            ]);
        } else {
            return $this->redirect(['site/articles']);
        }


    }


    public function actionPost()
    {
        $request = Yii::$app->request;
        $get = $request->get();

        $lesson = Lessons::find()
            ->select(['title','data','view','author','text','id','com','cat'])
            ->where('id=:id',[':id'=>$get['id']])
            ->one();

        $category = Categories::find()
            ->select(['title','id'])
            ->where('id=:id',[':id'=>$lesson->cat])
            ->one();


        $imges_profil = User::find()
            ->select(['imageFile','login'])
            ->all();
        $imageFile = [];
        foreach ($imges_profil as $key => $img_profil ) {
            $imageFile[$img_profil->login] =  $img_profil->imageFile;
        }

        if (!Yii::$app->request->post()) {
            if (!Yii::$app->user->isGuest) {
                if (isset($get['answer']) && $get['answer'] != Yii::$app->user->identity->login) {
                    $answer = $get['answer'] . ', ';
                } elseif ($get['answer'] == Yii::$app->user->identity->login) {
                    Yii::$app->session->setFlash("danger", 'Невозможно выполнить запрос!');

                } else {
                    $answer='';
                }
            }

        }

        $comment_model = new Comment();

        if ( Yii::$app->request->post('Comment'))
        {
            if (!Yii::$app->user->isGuest) {

                if(isset($get['answer']) && explode(',',Yii::$app->request->post('Comment')['text'])[0] == $get['answer'] && isset($imageFile[$get['answer']])) {
                        $comment_model->answer = $get['answer'];
                        $comment_model->viewed = 1;
                }
                $comment_model->attributes = Yii::$app->request->post('Comment');
                if ($comment_model->validate() && $comment_model->addComment()) {
                    if (!empty($comment_model->answer)) {
                        Yii::$app->session->setFlash("info",'Ваш ответ был успешно отправлен пользователю '. $comment_model->answer );
                    }
                    $lesson->updateCounters(['com' => 1]);
                    return $this->redirect(['site/post', 'id' => $get['id'], '#' => 'c']);
                }
            } else {
                return $this->redirect(['account/login']);
            }
        }

        $query = Comments::find()
            ->select(['author','date','text','id'])
            ->where('post=:id',[':id'=>$get['id']]);
        $pagination = new Pagination([
            'defaultPageSize'=>4,
            'totalCount'=>$query->count(),
        ]);
        $comments =$query->orderBy('date DESC,id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();



        $lesson->updateCounters(['view' => 1]);






        return $this->render('post',[
            'lesson'=>$lesson,
            'comment_model'=>$comment_model,
            'comments'=>$comments,
            'answer' => $answer,
            'pagination'=>$pagination,
            'imageFile' => $imageFile,
            'category'=>$category,
        ]);

    }

    public function actionAnswer()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $comment_model = new Comment();
        if (!Yii::$app->user->isGuest) {
            if(isset($get['id']) && isset($get['com_id'])) {
                $comment_model->viewed = 0;
            if ( $comment_model->addViewed()) {
             return $this->redirect(['site/post', 'id'=>$get['id']]);
            }
            } else {
                return $this->redirect(['account/index']);
            }
        } else {
            return $this->redirect(['account/login']);
        }
    }





    
}
