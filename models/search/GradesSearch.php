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
        // Define the query
        $query = Grades::find();

        // Configure the data provider with pagination and sorting options
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10, // Number of items per page
            ],
            'sort' => [
                'defaultOrder' => ['SUBMISSION_ID' => SORT_ASC], // Default sorting order
                'attributes' => [
                    'SUBMISSION_ID',
                    'GRADE',
                    'GRADED_AT'
                ]
            ],
        ]);

        // Load and validate search parameters
        $this->load($params);
        if (!$this->validate()) {
            // Return an empty data provider when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // Filtering conditions
        $query->andFilterWhere([
            'GRADE_ID' => $this->GRADE_ID,
            'SUBMISSION_ID' => $this->SUBMISSION_ID,
            'GRADE' => $this->GRADE,
            'GRADED_AT' => $this->GRADED_AT,
        ]);

        return $dataProvider;
    }
    
}