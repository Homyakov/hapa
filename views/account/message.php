<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
$this->title = 'Сообщения';
?>


<div id="dialog">

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?php foreach ($messages as $message): ?>
        <?php if ($message ->ot_kovo == Yii::$app->user->identity->login){ ?>

    <div class="comments first_level">

        <li>
            <div class="comment_box commentbox1">

                <div class="gravatar">
                    <img  src="../images/avator.png"  />
                </div>

                <div class="comment_text">

                    <div class="comment_author"><?= $message->ot_kovo ?><span class="date"><?= $message->date ?></span> </div>
                    <p><?= $message->text ?></p>
                </div>
                <div class="cleaner"></div>
            </div>

        </li>

</div>
    <?php } else { ?>


    <div class="comments second_level">

        <li>
            <div class="comment_box commentbox1">

                <div class="gravatar">
                    <img  src="../images/avator.png"  />
                </div>

                <div class="comment_text">

                    <div class="comment_author"><?= $message->ot_kovo ?><span class="date"><?= $message->date ?></span> </div>
                    <p><?= $message->text ?></p>
                </div>
                <div class="cleaner"></div>
            </div>

        </li>

    </div>
        <?php } ?>

        <?php endforeach; ?>
   
    <div class="message_pole">
        <?php
    $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);
        ?>
    <?=$form->field($model_message,'text')->textarea(['rows' => 8, 'cols' => 5])->label('') ?>
    <?=$form->field($model_message,'ot_kovo')->hiddenInput(['value'=>Yii::$app->user->identity->login])->label('') ?>
    <?=$form->field($model_message,'komy')->hiddenInput(['value'=>$info_account->login])->label('') ?>
    <?=Html::submitButton('Отправить', ['class' => 'btn btn-lg btn-success']) ?>

    <?php $form = ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>


