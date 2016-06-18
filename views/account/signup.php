<h1>Регистрация</h1>

<?php
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>

<?php
   $form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?= $form->field($model,'login')->textInput()->hint('Введите имя под которым в будите видны на сайте')->label('Логин') ?>

<?= $form->field($model,'password')->passwordInput()->label('Пароль') ?>

<?= $form->field($model,'password_repeat')->passwordInput()->label('Повторите пароль') ?>

<?= $form->field($model,'email')->textInput() ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-4">{input}</div></div>',
]) ?>

<div>
    <button type="submit" class="btn btn-success">Зарегистрироваться</button>
</div>


<?php
    ActiveForm::end();
?>
