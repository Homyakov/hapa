<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LessonsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lessons-admin-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'meta_d') ?>

    <?= $form->field($model, 'meta_k') ?>

    <?= $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'view') ?>

    <?php // echo $form->field($model, 'mini_img') ?>

    <?php // echo $form->field($model, 'cat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
