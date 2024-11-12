<?php 

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Courses;
use app\models\Assignments;
use app\models\Grades;
use app\models\User;
use yii\db\Query;

class ResultsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'instructor', 'student'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->identity->ID;
        $courseResults = [];

        if (Yii::$app->user->can('student')) {
            // Get results for the logged-in student
            $courseResults = $this->getStudentResults($userId);
        } elseif (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')) {
            // Get results for all students for admin/instructor
            $courseResults = $this->getAllStudentsResults();
        }

        return $this->render('index', [
            'courseResults' => $courseResults,
        ]);
    }

    private function getStudentResults($userId)
    {
        $results = [];
        $courses = Courses::find()
            ->joinWith('enrollments')
            ->where(['enrollments.USER_ID' => $userId])
            ->all();

        foreach ($courses as $course) {
            $averageGrade = $this->calculateAverageGrade($course->assignments, $userId);

            $results[] = [
                'student' => Yii::$app->user->identity,
                'course' => $course,
                'averageGrade' => $averageGrade,
            ];
        }

        return $results;
    }

    private function getAllStudentsResults()
    {
        $results = [];
        $students = (new Query())
            ->select(['user.*'])
            ->from('user')
            ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.ID')
            ->where(['auth_assignment.item_name' => 'student'])
            ->all();

        foreach ($students as $studentData) {
            $student = User::findOne($studentData['ID']);
            $enrollments = $student->enrollments;
            
            foreach ($enrollments as $enrollment) {
                $course = $enrollment->cOURSE;
                $averageGrade = $this->calculateAverageGrade($course->assignments, $student->ID);

                $results[] = [
                    'student' => $student,
                    'course' => $course,
                    'averageGrade' => $averageGrade,
                ];
            }
        }

        return $results;
    }

    private function calculateAverageGrade($assignments, $studentId)
    {
        $totalScore = 0;
        $totalOutOf = 0;

        foreach ($assignments as $assignment) {
            $grade = Grades::find()
                ->joinWith(['sUBMISSION.uSER', 'sUBMISSION.aSSIGNMENT'])
                ->where([
                    'uSER.ID' => $studentId,
                    'aSSIGNMENTS.ASSIGNMENT_ID' => $assignment->ASSIGNMENT_ID,
                ])
                ->one();

            if ($grade) {
                $totalScore += $grade->GRADE;
                $totalOutOf += $assignment->TOTAL_MARKS;
            }
        }

        return $totalOutOf > 0 ? ($totalScore / $totalOutOf) * 100 : 0;
    }

    public function actionRelease()
    {
        if (Yii::$app->user->can('admin')) {
            $courses = Courses::find()->all();
            foreach ($courses as $course) {
                $grades = Grades::find()->where(['COURSE_ID' => $course->COURSE_ID])->all();
                foreach ($grades as $grade) {
                    $grade->is_released = true;
                    $grade->save();
                }
            }

            Yii::$app->session->setFlash('success', 'Results released successfully.');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }
}
