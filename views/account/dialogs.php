<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = 'Диалоги';
?>

<div id="dialog">

    <?php if (empty($dialogs[0])) {
        echo "<H3>У вас пока нет активных диалогов</H3>";

    }  ?>
    <?php $i = 0 ; ?>
    <?php foreach ($dialogs as $dialog): ?>


    <?php  if ($dialog->pol1==Yii::$app->user->identity->login){ ?>
        <a href="<?php echo Url::to(['account/message', 'login' => $dialog->pol2 ]);  ?>"  class="my_dialog" > <div class="comments first_level" >

                <li>
                    <div class="comment_box commentbox1">

                        <div class="gravatar">
                            <img  src=""  />
                        </div>

                        <div class="comment_text">



                            <?php  if ($dialog->pol1==Yii::$app->user->identity->login){ ?>
                            <div class="comment_author"><?= $dialog->pol2 ?><span class="date"><?= $dialog->date ?></span> </div>
                                <?=$message[$i]['ot_kovo'] ?>:
                                <?=$message[$i]['text'] ?>
                                <?php
                                while ($message[$i]['komy']==$dialog->pol2 || $message[$i]['ot_kovo']==$dialog->pol2 ){
                                    $i++;

                                }    ?>
                               
                            <?php } else { ?>
                            <div class="comment_author"><?= $dialog->pol1 ?><span class="date"><?= $dialog->date ?></span> </div>
                                <?=$message[$i]['ot_kovo'] ?>:
                                <?=$message[$i]['text'] ?>
                                <?php
                                while ($message[$i]['komy']==$dialog->pol1 || $message[$i]['ot_kovo']==$dialog->pol1 ){
                                    $i++;

                                }    ?>
                            <?php } ?>




                        </div>
                        <div class="cleaner"></div>
                    </div>

                </li>

            </div> </a>
    <?php } else { ?>
    <a href="<?php echo Url::to(['account/message', 'login' => $dialog->pol1 ]);  ?>"  class="my_dialog" > <div class="comments first_level" >

            <li>
                <div class="comment_box commentbox1">

                    <div class="gravatar">
                        <img  src="../images/avator.png"  />
                    </div>

                    <div class="comment_text">



                        <?php  if ($dialog->pol1==Yii::$app->user->identity->login){ ?>
                            <div class="comment_author"><?= $dialog->pol2 ?><span class="date"><?= $dialog->date ?></span> </div>
                            <?=$message[$i]['ot_kovo'] ?>:
                            <?=$message[$i]['text'] ?>
                            <?php
                            while ($message[$i]['komy']==$dialog->pol2 || $message[$i]['ot_kovo']==$dialog->pol2 ){
                                $i++;

                            }    ?>

                        <?php } else { ?>
                            <div class="comment_author"><?= $dialog->pol1 ?><span class="date"><?= $dialog->date ?></span> </div>
                            <?=$message[$i]['ot_kovo'] ?>:
                            <?=$message[$i]['text'] ?>
                            <?php
                            while ($message[$i]['komy']==$dialog->pol1 || $message[$i]['ot_kovo']==$dialog->pol1 ){
                                $i++;

                            }    ?>
                        <?php } ?>




                    </div>
                    <div class="cleaner"></div>
                </div>

            </li>

        </div> </a>
        <?php } ?>

    <?php endforeach; ?>
</div>
<?= LinkPager::widget(['pagination'=>$pagination]) ?>

