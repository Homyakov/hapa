<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $this->title = 'Account'; ?>



<div class="account-profile">

    
    <br>
    <div class="account-img"><img src="<? echo $info_account->imageFile; ?>" width="100" height="100"></div>
    <div class="account-info">
        <div>Ваш логин: <? echo $info_account->login; ?></div>
        <div>Ф.И.О. : <? echo $info_account->name.' '.$info_account->lastname.' '.$info_account->fathername;; ?></div>
        <div>День рождения: <? echo $info_account->date; ?></div>
        <div>О себе: <? echo $info_account->aboutme; ?></div>




    </div>

<?php $form = ActiveForm::begin(['action'=>'massage']); ?>

<div class="account-button"><?= Html::submitButton('Написать сообщение', ['class' => 'btn btn-success', 'name' => 'account-button']) ?></div>
<?php ActiveForm::end(); ?>

</div>