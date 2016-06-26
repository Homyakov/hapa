<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Url;
?>

<?php $this->title = 'Account'; ?>
<h3>Личный кабинет</h3>


    <div class="account-profile">


        <h4><?php echo "Добро пожаловать на сайт, ".Yii::$app->user->identity->login ?></h4>
        <br>
        <div style="padding-top: 10px; padding-bottom:5px;">
            <a class="btn btn-default" href="<?php echo Url::to(['account/dialog']);  ?>">Сообщения</a>
        </div>
        <div class="account-img"><img src="<? echo $info_account->imageFile; ?>" width="100" height="100"></div>
        <div class="account-info">
             <div>Ваш логин: <? echo $info_account->login; ?></div>
             <div>Ваш email: <? echo $info_account->email; ?></div>
            <? if($info_account->name!=NULL && $info_account->name!=NULL && $info_account->name!=NULL )  {echo "<div>Ф.И.О. : ".$info_account->name.' '.$info_account->lastname.' '.$info_account->fathername."</div>"; }?>
            <? if($info_account->date!=NULL) { echo "<div>День рождения: ". $info_account->date."</div>";} ?>
            <? if($info_account->aboutme!=NULL) {echo "<div>О себе: ".  $info_account->aboutme."</div>";} ?>




        </div>

        <?php $form = ActiveForm::begin(['action'=>'change']); ?>

        <div class="account-button"><?= Html::submitButton('Изменить информацию о себе', ['class' => 'btn btn-success', 'name' => 'account-button']) ?></div>
        <?php ActiveForm::end();?>

            <?
            if(Yii::$app->session->has('success')) {
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-success'
                    ],
                    'body' => Yii::$app->session->getFlash('success')
                ]);
            }
            ?>




    </div>