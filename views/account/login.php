<h1>Логин</h1>
<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="col-lg-7">
<?php $form = ActiveForm::begin();  ?>

<?= $form->field($login_model,'login')->textInput()->label('Логин') ?>

<?= $form->field($login_model,'password')->passwordInput()->label('Пароль') ?>


<div>
    <button class="btn btn-success" type="submit">Войти</button>
</div>

<div style="padding-top: 10px;">
    <p><a class="btn btn-default" href="<?php echo Url::to(['account/signup']);  ?>">Регистрация </a></p>
</div>

<?php  $form = ActiveForm::end(); ?>
</div>
