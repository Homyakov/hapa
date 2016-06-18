<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lessons_admin */

$this->title = 'Добавить статью';
$this->params['breadcrumbs'][] = ['label' => 'Админка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lessons-admin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
