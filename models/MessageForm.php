<?php


namespace app\models;
use yii\base\Model;
use Yii;

class MessageForm extends Model
{
    public $text;
    public $ot_kovo;
    public $komy;

    public function rules()
    {
      return[[['text','ot_kovo','komy'],'safe']];
    }

    public function addMessage()
    {
        $message = new Message();
        $message->text = $this->text;
        $message->ot_kovo = $this->ot_kovo;
        $message->komy = $this->komy;
        
        return $message->save();
    }
}