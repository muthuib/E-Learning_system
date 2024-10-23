<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Assignments;

/**
 * AssignmentsSearch represents the model behind the search form of `app\models\Assignments`.
 */
class AssignmentsSearch extends Assignments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ASSIGNMENT_ID', 'COURSE_ID'], 'integer'],
            [['TITLE', 'DESCRIPTION', 'DUE_DATE', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
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
        $query = Assignments::find();

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
            'ASSIGNMENT_ID' => $this->ASSIGNMENT_ID,
            'COURSE_ID' => $this->COURSE_ID,
            'DUE_DATE' => $this->DUE_DATE,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

        $query->andFilterWhere(['like', 'TITLE', $this->TITLE])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION]);

        return $dataProvider;
    }
}
