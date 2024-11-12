<?php 
namespace app\models\search;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Assignments;
use app\models\Courses;
use app\models\Enrollment;

/**
 * AssignmentsSearch represents the model behind the search form of `app\models\Assignments`.
 */
class AssignmentsSearch extends Assignments
{
    public $courseId; // Make courseId available for searching

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ASSIGNMENT_ID', 'COURSE_ID'], 'integer'],
            [['TITLE', 'DESCRIPTION', 'DUE_DATE', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            ['courseId', 'safe'],  // Added for courseId
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Assignments::find();

        // Handle role-based filtering
        if (Yii::$app->user->can('instructor')) {
            // Instructor only sees assignments for courses they are assigned to
            $instructorId = Yii::$app->user->identity->ID;
            $assignedCourses = Courses::find()->select('COURSE_ID')->where(['instructor_id' => $instructorId])->column();
            $query->andWhere(['COURSE_ID' => $assignedCourses]);
                
                } elseif (Yii::$app->user->can('student')) {
            // Student only sees assignments for courses they are enrolled in
            $userId = Yii::$app->user->identity->ID;
            $enrolledCourses = (new \yii\db\Query())
                ->select('COURSE_ID')
                ->from('enrollments') // Assuming 'enrollments' is the table that stores user-course relationships
                ->where(['USER_ID' => $userId]) // Use USER_ID for filtering the enrolled courses
                ->column();
            $query->andWhere(['COURSE_ID' => $enrolledCourses]); // Only show assignments for enrolled courses
                }
                elseif (Yii::$app->user->can('student')) {
                    // Student only sees assignments for courses they are enrolled in
                    $userId = Yii::$app->user->identity->ID;
                    $enrolledCourses = (new \yii\db\Query())
                        ->select('COURSE_ID')
                        ->from('enrollments') // Assuming 'enrollments' is the table that stores user-course relationships
                        ->where(['USER_ID' => $userId]) // Use USER_ID for filtering the enrolled courses
                        ->column();
                    $query->andWhere(['COURSE_ID' => $enrolledCourses]); // Only show assignments for enrolled courses
                }

        // Filter by courseId if it's set
        if ($this->courseId) {
            $query->andWhere(['COURSE_ID' => $this->courseId]);
        }

        // Prepare the data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Load the params and validate
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
