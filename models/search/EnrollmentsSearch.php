<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Enrollments;

/**
 * EnrollmentsSearch represents the model behind the search form of `app\models\Enrollments`.
 */
class EnrollmentsSearch extends Enrollments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ENROLLMENT_ID', 'USER_ID', 'COURSE_ID'], 'integer'],
            [['ENROLLED_AT'], 'safe'],
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
    // public function search($params)
    // {
    //     $query = Enrollments::find();

    //     // add conditions that should always apply here

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProvider;
    //     }

    //     // grid filtering conditions
    //     $query->andFilterWhere([
    //         'ENROLLMENT_ID' => $this->ENROLLMENT_ID,
    //         'USER_ID' => $this->USER_ID,
    //         'COURSE_ID' => $this->COURSE_ID,
    //         'ENROLLED_AT' => $this->ENROLLED_AT,
    //     ]);

    //     return $dataProvider;
    // }
    public function search($params, $userId = null)
    {
        $query = Enrollments::find();

        // Load the parameters
        $this->load($params);

        // If userId is provided, filter by USER_ID
        if ($userId !== null) {
            $query->andFilterWhere(['USER_ID' => $userId]);
        }

        // Add other filters here as needed
        // For example: $query->andFilterWhere(['like', 'COURSE_NAME', $this->COURSE_NAME]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

}