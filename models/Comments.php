<?php
/**
 * Created by PhpStorm.
 * User: VsDragon
 * Date: 17.05.2016
 * Time: 17:09
 */

namespace app\models;

use Yii\db\ActiveRecord;

class Comments extends ActiveRecord
{
    public static function tableName()
    {
        return 'comments';
    }


}