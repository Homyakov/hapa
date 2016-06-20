<?php
/**
 * Created by PhpStorm.
 * User: VsDragon
 * Date: 17.05.2016
 * Time: 16:10
 */

namespace app\models;
use yii\base\Model;
use Yii;

class Comment extends Model
{
    public $text;
    public $author;
    public $date;
    public $post;
    public $answer;

    public function rules()
    {
        return [
            [['text'],'filter', 'filter' => 'stripslashes', 'skipOnArray' => true],
            [['text'],'filter', 'filter' => 'htmlspecialchars', 'skipOnArray' => true],
            ['answer', 'match', 'pattern' => '/^[a-z]\w*$/i']
            ];
    }

    public function addComment()
    {
        $comment = new Comments();
        $comment->text = $this->text;
        $comment->author = Yii::$app->user->identity->login ;
        $comment->date = date('Y-m-d');
        $comment->post = Yii::$app->request->get('id');
        $comment->answer = $this->answer;

        return $comment->save();
    }


}