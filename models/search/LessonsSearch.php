<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lessons;

/**
 * LessonsSearch represents the model behind the search form of `app\models\Lessons`.
 */
class LessonsSearch extends Lessons
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LESSON_ID', 'COURSE_ID'], 'integer'],
            [['TITLE', 'CONTENT', 'VIDEO_URL', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
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
        $query = Lessons::find();

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
            'LESSON_ID' => $this->LESSON_ID,
            'COURSE_ID' => $this->COURSE_ID,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

        $query->andFilterWhere(['like', 'TITLE', $this->TITLE])
            ->andFilterWhere(['like', 'CONTENT', $this->CONTENT])
            ->andFilterWhere(['like', 'VIDEO_URL', $this->VIDEO_URL]);

        return $dataProvider;
    }
}
