<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QuizAnswers;

/**
 * QuizAnswersSearch represents the model behind the search form of `app\models\QuizAnswers`.
 */
class QuizAnswersSearch extends QuizAnswers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'QUIZ_ID', 'QUESTION_ID', 'USER_ID'], 'integer'],
            [['ANSWER_TYPE', 'ANSWER', 'USER_ANSWER', 'CREATED_AT'], 'safe'],
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
        $query = QuizAnswers::find();

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
            'QUIZ_ID' => $this->QUIZ_ID,
            'QUESTION_ID' => $this->QUESTION_ID,
            'USER_ID' => $this->USER_ID,
            'CREATED_AT' => $this->CREATED_AT,
        ]);

        $query->andFilterWhere(['like', 'ANSWER_TYPE', $this->ANSWER_TYPE])
            ->andFilterWhere(['like', 'ANSWER', $this->ANSWER])
            ->andFilterWhere(['like', 'USER_ANSWER', $this->USER_ANSWER]);

        return $dataProvider;
    }
}
