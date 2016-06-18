<?php

use yii\bootstrap\Carousel;


use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
   

    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>

        <p class="lead">У нас вы найдете множество интересных статей о новинках IT-идустрии.</p>

        <p><a class="btn btn-lg btn-success" href="<?php echo Url::to(['site/articles' ]);  ?>">Перейти к просмотру</a></p>
    </div>
<div style="padding-bottom: 100px;">
  <?php
    echo Carousel::widget ( [
    'items' => [
    [
    'content' => '<img  src="../images/2.png"/>',
    'caption' => '<h2>Yii Gii</h2><p>Удобный встроенный генератор кода. Модули, модели на основе таблиц в БД и, конечно же, CRUD</p>',
    'options' => []
    ],
    [
    'content' => '<img  src="../images/4.png"/>',
    'caption' => '<h2>Отличный отладчик</h2><p>Легко подключается, помнит все запросы http, БД и логи</p>',
    'options' => []
    ],
    [
    'content' => '<img src="../images/5.png"/>',
    'caption' => '<h2>Быстрый старт</h2><p>Установка и обновление через composer</p>',
    'options' => []
    ]
    ],
    'options' => [
    'style' => 'width:900px; height:400px; margin: 0 auto;' // Задаем ширину контейнера
    ]
    ]);
?></div>
    <div class="body-content">

        <div class="row">
            <?php foreach ($categories as $category): ?>
            <div class="col-lg-4">
                <h2><?= $category->title ?></h2>

                <p><?= $category->description ?></p>

                <p><a class="btn btn-default" href="<?php echo Url::to(['site/category', 'id' => $category->id ]);  ?>">Узнать больше &raquo;</a></p>
            </div>
            <?php endforeach; ?>

        </div>

    </div>
</div>
