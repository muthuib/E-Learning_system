<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Submissions;

/**
 * SubmissionsSearch represents the model behind the search form of `app\models\Submissions`.
 */
class SubmissionsSearch extends Submissions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SUBMISSION_ID', 'ASSIGNMENT_ID', 'USER_ID'], 'integer'],
            [['FILE_URL', 'SUBMITTED_AT'], 'safe'],
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
        $query = Submissions::find();

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
            'SUBMISSION_ID' => $this->SUBMISSION_ID,
            'ASSIGNMENT_ID' => $this->ASSIGNMENT_ID,
            'USER_ID' => $this->USER_ID,
            'SUBMITTED_AT' => $this->SUBMITTED_AT,
        ]);

        $query->andFilterWhere(['like', 'FILE_URL', $this->FILE_URL]);

        return $dataProvider;
    }
}
