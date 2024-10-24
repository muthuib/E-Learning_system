<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grades;

/**
 * GradesSearch represents the model behind the search form of `app\models\Grades`.
 */
class GradesSearch extends Grades
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['GRADE_ID', 'SUBMISSION_ID'], 'integer'],
            [['GRADE'], 'number'],
            [['GRADED_AT'], 'safe'],
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
        $query = Grades::find();

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
            'GRADE_ID' => $this->GRADE_ID,
            'SUBMISSION_ID' => $this->SUBMISSION_ID,
            'GRADE' => $this->GRADE,
            'GRADED_AT' => $this->GRADED_AT,
        ]);

        return $dataProvider;
    }
}
