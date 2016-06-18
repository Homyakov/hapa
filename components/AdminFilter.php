<?php

namespace app\components;

use Yii;
use yii\base\ActionFilter;


class AdminFilter extends ActionFilter
{
    public function beforeAction($action)
    {
       if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login === "admin"){
           return true;
       }
        else {
            return false;
        }
    }

}