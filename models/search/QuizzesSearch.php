<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quizzes;

/**
 * QuizzesSearch represents the model behind the search form of `app\models\Quizzes`.
 */
class QuizzesSearch extends Quizzes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'DURATION'], 'integer'],
            [['NAME', 'CREATED_AT'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Quizzes::find();

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
            'ID' => $this->ID,
            'DURATION' => $this->DURATION,
            'CREATED_AT' => $this->CREATED_AT,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME]);

        return $dataProvider;
    }
}
