<?php

namespace app\controllers;

use Yii;
use app\models\Courses;
use app\models\Lessons;
use app\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\search\LessonsSearch;

/**
 * LessonsController implements the CRUD actions for Lessons model.
 */
class LessonsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        //restricting user access not to type unauthorized directory  to access it when logged in
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['delete', 'create', 'update', 'view', 'index'], // Specify the actions to protect
                        'allow' => true,
                        'roles' => ['admin'], // Allow access for these roles
                    ],
                    [
                        'actions' => ['delete', 'create', 'update', 'view', 'index'], // Specify the actions to protect
                        'allow' => true,
                        'roles' => ['instructor'], // Allow access for these roles
                    ],
                    [
                        'actions' => ['index', 'view'], // Same actions
                        'allow' => true, // Deny access to other users
                        'roles' => ['student'], // Authenticated users
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'You do not have permission to access this page.');
                            return Yii::$app->response->redirect(['site/index']); // Redirect to the home page or any page
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Lessons models.
     *
     * @return string
     */
    public function actionIndex($courseId = null)
    {
        $userId = Yii::$app->user->id; // Current logged-in user ID
        $authManager = Yii::$app->authManager;

        // Check user roles
        $isInstructor = $authManager->getAssignment('instructor', $userId) !== null;
        $isStudent = $authManager->getAssignment('student', $userId) !== null;

        if ($isInstructor) {
            // Fetch courses assigned to this instructor that have lessons
            $courses = Courses::find()
                ->where(['INSTRUCTOR_ID' => $userId])
                ->innerJoinWith('lessons') // Assuming 'lessons' relation in Courses model
                ->all();
        } elseif ($isStudent) {
            // Fetch courses where the student is enrolled
            $courses = Courses::find()
                ->innerJoin('enrollments', 'enrollments.COURSE_ID = courses.COURSE_ID')
                ->where(['enrollments.USER_ID' => $userId])
                ->all();
        } else {
            // If admin, fetch all courses
            $courses = Courses::find()->all();
        }

        // Calculate lesson counts for each course
        $courseLessonCounts = [];
        foreach ($courses as $course) {
            $courseLessonCounts[$course->COURSE_ID] = Lessons::find()
                ->where(['COURSE_ID' => $course->COURSE_ID])
                ->count();
        }

        // Set up the lessons data provider based on selected course ID
        $dataProvider = new ActiveDataProvider([
            'query' => Lessons::find()->where(['COURSE_ID' => $courseId]),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'courses' => $courses,
            'courseLessonCounts' => $courseLessonCounts,
            'selectedCourseId' => $courseId,
        ]);
    }

    /**
     * Displays a single Lessons model.
     * @param int $LESSON_ID Lesson ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($LESSON_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($LESSON_ID),
        ]);
    }

    /**
     * Creates a new Lessons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Lessons();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Lesson added successfully.');
                return $this->redirect(['index', 'LESSON_ID' => $model->LESSON_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing Lessons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $LESSON_ID Lesson ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($LESSON_ID)
    {
        $model = $this->findModel($LESSON_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Lesson updated successfully.');
            return $this->redirect(['index', 'LESSON_ID' => $model->LESSON_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lessons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $LESSON_ID Lesson ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($LESSON_ID)
    {
        $this->findModel($LESSON_ID)->delete();
        Yii::$app->session->setFlash('danger', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Lesson deleted successfully.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lessons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $LESSON_ID Lesson ID
     * @return Lessons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($LESSON_ID)
    {
        if (($model = Lessons::findOne(['LESSON_ID' => $LESSON_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}