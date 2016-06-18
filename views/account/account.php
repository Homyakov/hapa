<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
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
             <div>Ф.И.О. : <? echo $info_account->name.' '.$info_account->lastname.' '.$info_account->fathername;; ?></div>
             <div>День рождения: <? echo $info_account->date; ?></div>
             <div>О себе: <? echo $info_account->aboutme; ?></div>




        </div>

        <?php $form = ActiveForm::begin(['action'=>'change']); ?>

        <div class="account-button"><?= Html::submitButton('Изменить информацию о себе', ['class' => 'btn btn-success', 'name' => 'account-button']) ?></div>
        <?php ActiveForm::end(); ?>

    </div>