
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;



$this->title = $lessons->title ;
?>
<div class="toplink">
    <a href="#" class="h1" title="К началу"><span class="glyphicon glyphicon-arrow-up"></span></a>
</div>

<div id="templatemo_main">
    <div id="content">
        <div class="post">

            <h2><?= $lessons->title ?></h2>
            <div class="meta">
                <span class="admin"><?= $lessons->author ?></span>
                <span class="date"><?= $lessons->data ?></span>
                <span class="comment"><?= $lessons->com ?></span>
                <span class="view"><?= $lessons->view?></span>
                <div class="cleaner"></div>
            </div>
            <p><?= $lessons->text ?></p>

            <div class="cleaner"></div>
        </div>
        <div>

            <?php Pjax::begin(); ?>

            <div id="comment_section">


                <?php foreach ($comments as $comment): ?>
                <ol class="comments first_level">

                    <li>
                        <div class="comment_box commentbox1">

                            <div class="gravatar">
                                <img  src="../images/avator.png"  />
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
                                                    'url' => '#'
                                                ],
                                                [
                                                    'label' => 'Профиль',
                                                    'url' => Url::to(['site/profil','login'=> $comment->author])
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

            <h1>Добавить комментарий</h1>
            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);  ?>

            <?= $form->field($comment_model,'text')->textarea(['rows' => 8, 'cols' => 5])->label('Введите текст комментария') ?>
            <?php
            if (Yii::$app->user->isGuest)
                echo  "<p id='com_worn'>Для добавления комментариев необходимо авторизироваться </p>";
            ?>
            <div>


                <?= Html::submitButton('добавить', ['class' => 'btn btn-lg btn-success']) ?>
            </div>

            <?php  $form = ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>



    </div>


</div>


