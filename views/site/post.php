
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Alert;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use yii\widgets\LinkPager;



$this->title = $lesson->title ;
$this->params['breadcrumbs'][] = ['template' => "<li><a>{link}</a></li>",'url'=>Url::to(['site/articles']),'label'=>'Статьи',];
$this->params['breadcrumbs'][] = ['template' => "<li><a>{link}</a></li>",'url'=>Url::to(['site/category','id'=>$category->id]),'label'=>$category->title];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="toplink">
    <a href="#" class="h1" title="К началу"><span class="glyphicon glyphicon-arrow-up"></span></a>
</div>

<div id="templatemo_main">
    <div id="content">
        <div class="post">

            <h2><?= $lesson->title ?></h2>
            <div class="meta">
                <span class="admin"><?= $lesson->author ?></span>
                <span class="date"><?= $lesson->data ?></span>
                <span class="comment"><?= $lesson->com ?></span>
                <span class="view"><?= $lesson->view?></span>
                <div class="cleaner"></div>
            </div>
            <p><?= $lesson->text ?></p>

            <div class="cleaner"></div>
        </div>
        <div>

            <?php Pjax::begin(['enablePushState'=>false]); ?>

            <div id="comment_section">
<a name="d"></a>

                <?php foreach ($comments as $comment): ?>

                <ol class="comments first_level">

                    <li>
                        <?php if(Yii::$app->user->identity->login==="admin") {
                            printf("<div><a href='%s' title='Delete' aria-label='Delete' data-confirm='Вы уверены что хотите удалить комментарий?' data-method='post' data-pjax='0'><span class='glyphicon glyphicon-trash'></span></a></div>", Url::to(['admin/delcom', 'com_id' => $comment->id, 'id' => $_GET['id']]));
                        }
                        ?>
                        <div class="comment_box commentbox1">
                            <a name="<?=$comment->id?>"></a>
                            <div class="gravatar">
                                <img  src="<?=$imageFile[$comment->author]?>"  />
                            </div>

                            <div class="comment_text">

                                <div class="comment_author"><?php
                                    echo ButtonDropdown::widget([
                                        'label' => $comment->author,
                                        'options' => [
                                            'class' => 'btn-lg btn-link',
                                            'style' => 'margin:1px'
                                        ],
                                        'dropdown' => [
                                            'items' => [
                                                [
                                                    'label' => 'Ответить',
                                                    'url' => Url::to(['site/post','id'=> $_GET['id'],'answer'=> $comment->author,'#'=>'c'])
                                                ],
                                                [
                                                    'label' => 'Профиль',
                                                    'url' => Url::to(['friend/profil','login'=> $comment->author])
                                                ],

                                            ]
                                        ]
                                    ]);
                                    ?><span class="date"><?= Yii::$app->formatter->asDate($comment->date); ?></span> </div>
                                <p><?= $comment->text ?></p>
                            </div>
                            <div class="cleaner"></div>
                        </div>

                    </li>



                    <?php endforeach; ?>
            </div>

            <?= LinkPager::widget([
                'pagination'=>$pagination,
                'maxButtonCount'=>5,
                'hideOnSinglePage'=>true,
                'pageCssClass'=>''
            ]) ?>

            <?
           if(Yii::$app->session->has('info')) {
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-info'
                    ],
                    'body' => Yii::$app->session->getFlash('info')
                ]);
            }
            if(Yii::$app->session->has('danger')) {
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-danger'
                    ],
                    'body' => Yii::$app->session->getFlash('danger')
                ]);
            }


            ?>


<a name="c"></a>
            <h1>Добавить комментарий</h1>
            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);

            ?>

            <?= $form->field($comment_model,'text')->textarea(['rows' => 8, 'cols' => 5, 'value'=>$answer])->label('Введите текст комментария') ?>
            <?php
            if (Yii::$app->user->isGuest)
                echo  "<p id='com_worn'>Для добавления комментариев необходимо авторизироваться </p>";
            ?>
            <div>


                <?= Html::submitButton('Добавить', ['class' => 'btn btn-lg btn-success']) ?>
            </div>

            <?php  $form = ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
            <a id="linc"></a>
        </div>


    </div>


</div>


