<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;


$this->title = 'Articles';
?>

<?php $form = ActiveForm::begin();  ?>

<div class="form-wrapper cf">
   <input name="search" type="text" placeholder="Введите здесь слово, которое нужно найти..." required>
   <button type="submit">Искать</button>
</div>

<?php  $form = ActiveForm::end(); ?>


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
        <span class="view"> <?=$lesson->view?></span>
        <div class="cleaner"></div>
    </div>
    <img src="<?='../'.$lesson->mini_img ?>" />
    
    <p><?= $lesson->description ?></p>
    <a href="<?php echo Url::to(['site/post', 'id' => $lesson->id ]);  ?>" class="more float_r">Читать</a>
    <div class="cleaner"></div>
</div>
        </div>
    </div>
<?php  endforeach;  ?>
</div>

    <div class="toplink">
        <a href="#" class="h1" title="К началу"><span class="glyphicon glyphicon-arrow-up"></span></a>
    </div>

<?= LinkPager::widget(['pagination'=>$pagination]) ?>

