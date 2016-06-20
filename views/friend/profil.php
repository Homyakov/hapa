<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Collapse;
?>

<?php $this->title = 'Account'; ?>



<div class="account-profile">

    
    <br>
    <div class="account-img"><img src="<? echo $info_account->imageFile; ?>" width="100" height="100"></div>
    <div class="account-info">
        <div>Логин: <? echo $info_account->login; ?></div>
        <div>Ф.И.О. : <? echo $info_account->name.' '.$info_account->lastname.' '.$info_account->fathername;; ?></div>
        <div>День рождения: <? echo $info_account->date; ?></div>
        <div>О себе: <? echo $info_account->aboutme; ?></div>




    </div>

    <?php
    $form = ActiveForm::begin();
    echo Collapse::widget([
    'items' => [
    [
    'label' => 'Написать сообщение',
    'content' =>$form->field($model_message,'text')->textarea(['rows' => 8, 'cols' => 5])->label('').
        $form->field($model_message,'ot_kovo')->hiddenInput(['value'=>Yii::$app->user->identity->login])->label('').
        $form->field($model_message,'komy')->hiddenInput(['value'=>$info_account->login])->label('').
        Html::submitButton('Написать', ['class' => 'btn btn-lg btn-success']),
    
    'contentOptions' => [],
    'options' => []
    ],
    ]
    ]); ?>

<?php $form = ActiveForm::end(); ?>

</div>