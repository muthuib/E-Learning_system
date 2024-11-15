<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QuizAttempts;

/**
 * QuizAttemptsSearch represents the model behind the search form of `app\models\QuizAttempts`.
 */
class QuizAttemptsSearch extends QuizAttempts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'USER_ID', 'QUIZ_ID'], 'integer'],
            [['START_TIME', 'END_TIME'], 'safe'],
            [['SCORE'], 'number'],
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
        $query = QuizAttempts::find();

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
            'USER_ID' => $this->USER_ID,
            'QUIZ_ID' => $this->QUIZ_ID,
            'START_TIME' => $this->START_TIME,
            'END_TIME' => $this->END_TIME,
            'SCORE' => $this->SCORE,
        ]);

        return $dataProvider;
    }
}
