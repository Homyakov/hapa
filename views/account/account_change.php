<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $this->title = 'Account'; ?>
<h3>Личный кабинет</h3>


<div class="account-profile">


    <h4><?php echo "Добро пожаловать на сайт, ".Yii::$app->user->identity->login ?></h4>
    <br>
    <?php $form = ActiveForm::begin(['action'=>'save','options'=>['enctype'=>'multipart/form-data']]); ?>
    <div class="account-img">
        <img src="../images/avator.png">

    </div>
    <div class="account-info ">

        <?= $form->field($account_change,'imageFile')->fileInput()->label('Аватар') ?>
        <?= $form->field($account_change,'login')->textInput(['value'=>Yii::$app->user->identity->login])->label('Логин') ?>
        <?= $form->field($account_change,'email')->textInput(['value'=>Yii::$app->user->identity->email])->label('Email') ?>
        <?= $form->field($account_change,'name')->textInput(['value'=>Yii::$app->user->identity->name])->label('Имя') ?>
        <?= $form->field($account_change,'lastname')->textInput(['value'=>Yii::$app->user->identity->lastname])->label('Фамилия') ?>
        <?= $form->field($account_change,'fathername')->textInput(['value'=>Yii::$app->user->identity->fathername])->label('Отчество') ?>
        <label>Дата вашего рождения<br>
            <div><input  class="happy-day" name="date" type="date" value="<?=Yii::$app->user->identity->date ?>" size="100"></div>
        </label><br>
        <?= $form->field($account_change,'aboutme')->textarea(['value'=>Yii::$app->user->identity->aboutme])->label('О себе') ?>
    </div>



    <div class="account-button"><?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'name' => 'account-save']) ?></div>
    <?php ActiveForm::end(); ?>

</div>