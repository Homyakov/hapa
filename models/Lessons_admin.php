<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Lessons".
 *
 * @property integer $id
 * @property string $title
 * @property string $meta_d
 * @property string $meta_k
 * @property string $data
 * @property string $description
 * @property string $text
 * @property string $author
 * @property integer $view
 * @property string $mini_img
 * @property integer $cat
 */
class Lessons_admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Lessons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['description', 'text', 'cat'], 'required'],
            [['description', 'text'], 'string'],
            [['view', 'cat'], 'integer'],
            [['title', 'meta_d', 'meta_k', 'author', 'mini_img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'meta_d' => 'Meta D',
            'meta_k' => 'Meta K',
            'data' => 'Data',
            'description' => 'Description',
            'text' => 'Text',
            'author' => 'Author',
            'view' => 'View',
            'mini_img' => 'Mini Img',
            'cat' => 'Cat',
        ];
    }
}
