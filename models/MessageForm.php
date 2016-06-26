<?php


namespace app\models;
use yii\base\Model;
use Yii;

class MessageForm extends Model
{
    public $text;
    public $ot_kovo;
    public $komy;
    public $date;

    public function rules()
    {
      return[[['text','ot_kovo','komy'],'safe'],
          [['text','ot_kovo','komy'],'filter', 'filter' => 'stripslashes', 'skipOnArray' => true],
          [['text','ot_kovo','komy'],'filter', 'filter' => 'htmlspecialchars', 'skipOnArray' => true],];
    }

    public function addMessage()
    {
        $message = new Message();
        $message->text = $this->text;
        $message->ot_kovo = $this->ot_kovo;
        $message->komy = $this->komy;
        $message->time = time();
        $message->date = date('Y-m-d');
        
        return $message->save();
    }

    public function found_dialog(){

        $dialogs = Dialogs::find()
            ->where([
                'or',[
                    'and','pol1=:log1','pol2=:log2'
                ],
                [
                    'and','pol1=:log2','pol2=:log1'
                ]
            ])
            ->addParams([
                ':log1'=>Yii::$app->user->identity->login,
                ':log2'=>$this->komy
            ])
            ->one();
        return $dialogs;
    }
    
    public function updateDate(){
        $found = $this->found_dialog();
        $found->date = date('Y-m-d');
        $found->time = time();
        return $found->save();
    }
    
    public function addDialog(){
        $found = new Dialogs();
        $found->pol1 = $this->ot_kovo;
        $found->pol2= $this->komy;
        $found->time = time();
        $found->date = date('Y-m-d');
        return $found->save();
    }

   
}