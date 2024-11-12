<?php

namespace app\controllers;

use Yii;
use app\models\Courses;
use app\web\Controller;
use app\models\Enrollments;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\search\EnrollmentsSearch;

/**
 * EnrollmentsController implements the CRUD actions for Enrollments model.
 */
class EnrollmentsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
        //restricting user access not to type unauthorized directory  to access it when logged in
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['students-per-course', 'delete','create', 'update', 'view'], // Specify the actions to protect
                        'allow' => true,
                        'roles' => ['admin'], // Allow access for these roles
                    ],
                    [
                        'actions' => ['students-per-course', 'index', 'view', 'create'], // Specify the actions to protect
                        'allow' => true,
                        'roles' => ['instructor'], // Allow access for these roles
                    ],
                    [
                        'actions' => ['index', 'view', 'create'], // Same actions
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
     * Lists all Enrollments models.
     *
     * @return string
     */
    // 
    public function actionIndex()
    {
        $searchModel = new EnrollmentsSearch();

        // Check if the user is an admin or instructor
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')) {
            $dataProvider = $searchModel->search($this->request->queryParams);
        } else {
            // If the user is a student, filter enrollments for that specific user 
            //also modify your search model
            $dataProvider = $searchModel->search($this->request->queryParams, Yii::$app->user->id);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Enrollments model.
     * @param int $ENROLLMENT_ID Enrollment ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ENROLLMENT_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ENROLLMENT_ID),
        ]);
    }

    /**
     * Creates a new Enrollments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Enrollments();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Course enrolled successfully.');
                return $this->redirect(['index', 'ENROLLMENT_ID' => $model->ENROLLMENT_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    //FUNCTION TO ENSURE THAT ONLY COURSES WHICH ARE NOT ENROLLED BY LOGGED IN USER ARE AVAILABLE IN THE DROPDOWN.
   // <!-- Add the AJAX script in the view -->
//<!-- Ensures that only courses which are not enrolled by logged in user are available in the dropdown -->
    public function actionGetAvailableCourses()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $enrolledCourseIds = Enrollments::find()
            ->select('COURSE_ID')
            ->where(['USER_ID' => Yii::$app->user->id])
            ->column();

        $availableCourses = Courses::find()
            ->where(['NOT IN', 'COURSE_ID', $enrolledCourseIds])
            ->all();

        return ArrayHelper::map($availableCourses, 'COURSE_ID', 'COURSE_NAME');
    }

    /**
     * Updates an existing Enrollments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ENROLLMENT_ID Enrollment ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ENROLLMENT_ID)
    {
        $model = $this->findModel($ENROLLMENT_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Course enrolment updated successfully.');
            return $this->redirect(['index', 'ENROLLMENT_ID' => $model->ENROLLMENT_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Enrollments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ENROLLMENT_ID Enrollment ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ENROLLMENT_ID)
    {
        $this->findModel($ENROLLMENT_ID)->delete();
        Yii::$app->session->setFlash('danger', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Course enrollment deleted successfully.');


        return $this->redirect(['students-per-course']);
    }

    /**
     * Finds the Enrollments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ENROLLMENT_ID Enrollment ID
     * @return Enrollments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ENROLLMENT_ID)
    {
        if (($model = Enrollments::findOne(['ENROLLMENT_ID' => $ENROLLMENT_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    //function to show students enrolled per course
    public function actionStudentsPerCourse()
    {
        // Check if the user is an admin
        if (Yii::$app->user->can('admin')) {
            // Admins see all courses
            $courses = Courses::find()->with('enrollments.uSER')->all();
        } else {
            // Instructors see only the courses they are assigned to
            $instructorId = Yii::$app->user->identity->ID;
            $courses = Courses::find()
                ->where(['instructor_id' => $instructorId])
                ->with('enrollments.uSER')
                ->all();
        }

        return $this->render('students-per-course', [
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => $courses,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
        ]);
    }


}