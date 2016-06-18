<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LessonsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Админка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lessons-admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить статью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'meta_d',
            'meta_k',
            'data',
            // 'description:ntext',
            // 'text:ntext',
            // 'author',
            // 'view',
            // 'mini_img',
            // 'cat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
