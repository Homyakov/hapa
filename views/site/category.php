<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['template' => "<li><a>{link}</a></li>",'url'=>Url::to(['site/articles']),'label'=>'Статьи',];
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1 style="text-align: center;">Статьи по категории-<?= $category->title ?></h1>
    <div class="lesson">
        <?php foreach ($lessons as $lesson): ?>
            <div id="templatemo_main">
                <div id="content">
                    <div class="post">

                        <h2><a href="<?php echo Url::to(['site/post', 'id' => $lesson->id ]);  ?>" class="title "><?= $lesson->title ?></a></h2>
                        <div class="meta">
                            <span class="admin"><?= $lesson->author ?></span>
                            <span class="date"><?= $lesson->data ?></span>
                            <span class="comment"><?= $lesson->com ?></span>
                            <span class="view"><?= $lesson->view?></span>
                            <div class="cleaner"></div>
                        </div>
                        <img src="<?='../'.$lesson->mini_img ?>" alt="Image 01" />
                        <p><?= $lesson->description ?></p>
                        <a href="<?php echo Url::to(['site/post', 'id' => $lesson->id ]);  ?>" class="more float_r">Читать</a>
                        <div class="cleaner"></div>
                    </div>
                </div>
            </div>
        <?php  endforeach;  ?>
    </div>

<?= LinkPager::widget(['pagination'=>$pagination]) ?>