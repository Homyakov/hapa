<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lessons_admin;

/**
 * LessonsSearch represents the model behind the search form about `app\models\Lessons_admin`.
 */
class LessonsSearch extends Lessons_admin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'view', 'cat'], 'integer'],
            [['title', 'meta_d', 'meta_k', 'data', 'description', 'text', 'author', 'mini_img'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Lessons_admin::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'data' => $this->data,
            'view' => $this->view,
            'cat' => $this->cat,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'meta_d', $this->meta_d])
            ->andFilterWhere(['like', 'meta_k', $this->meta_k])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'mini_img', $this->mini_img]);

        return $dataProvider;
    }
}
