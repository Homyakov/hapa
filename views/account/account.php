<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Collapse;
?>

<?php $this->title = 'Account'; ?>
<h3>Личный кабинет</h3>


    <div class="account-profile">


        <h4><?php echo "Добро пожаловать на сайт, ".Yii::$app->user->identity->login ?></h4>
        <br>
        <div class="account-img"><img src="<? echo $info_account->imageFile; ?>" width="100" height="100"></div>
        <div class="account-info">
             <div>Ваш логин: <? echo $info_account->login; ?></div>
             <div>Ваш email: <? echo $info_account->email; ?></div>
            <? if($info_account->name!=NULL && $info_account->name!=NULL && $info_account->name!=NULL )  {echo "<div>Ф.И.О. : ".$info_account->name.' '.$info_account->lastname.' '.$info_account->fathername."</div>"; }?>
            <? if($info_account->date!=NULL) { echo "<div>День рождения: ". $info_account->date."</div>";} ?>
            <? if($info_account->aboutme!=NULL) {echo "<div>О себе: ".  $info_account->aboutme."</div>";} ?>




        </div>
        <div>
        <div class="account-button">
        <?php $form = ActiveForm::begin(['action'=>'change']); ?>

        <?= Html::submitButton('Изменить информацию о себе', ['class' => 'btn btn-success', 'name' => 'account-button']) ?>
        <?php ActiveForm::end();?>
        </div>

        <div class="collaps-answer"><?php

            foreach($comments as $comment) {
                foreach($lessons_title as $lesson_title) {
                    if($lesson_title->id == $comment->post) {
                        $comment->date = Yii::$app->formatter->asDate($comment->date);
                        echo Alert::widget([
                            'options' => [
                                'class' => 'alert-info'
                            ],
                            'body' => "<div class='alert-answer'>Вам ответил пользователь $comment->author в статье: </div>".
                                "<div class='alert-answer'>$comment->date</div>".
                                "<div><a href='/basic/web/site/answer?id=$comment->post&com_id=$comment->id' >$lesson_title->title</a> </div>"
                        ]);
                    }
                }
            }






        ?> </div></div>



        <?
        if(Yii::$app->session->has('success')) {
            echo Alert::widget([
                'options' => [
                    'class' => 'alert-success'
                ],
                'body' => Yii::$app->session->getFlash('success')
            ]);
        }
        ?>



    </div>