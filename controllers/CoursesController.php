<?php

namespace app\controllers;

use Yii;
use app\models\Courses;
use app\models\Lessons;
use app\web\Controller;
use app\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\search\CoursesSearch;
/**
 * CoursesController implements the CRUD actions for Courses model.
 */
class CoursesController extends Controller
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
                        'actions' => ['index', 'delete', 'create', 'update', 'view', 'continue-classes'], // Specify the actions to protect
                        'allow' => true,
                        'roles' => ['admin'], // Allow access for these roles
                    ],
                    [
                        'actions' => ['index', 'view', 'continue-classes'], // Same actions
                        'allow' => true, // Deny access to other users
                        'roles' => ['student', 'instructor'], // Authenticated users
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
     * Lists all Courses models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CoursesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionContinueClasses($courseId)
    {
        // Ensure the courseId is valid
        $course = Courses::findOne($courseId);

        if (!$course) {
            throw new NotFoundHttpException('The requested course does not exist.');
        }
        // Get lessons for the selected course
        $dataProvider = new ActiveDataProvider([
            'query' => Lessons::find()->where(['COURSE_ID' => $courseId]),
        ]);

        // Render the 'continue-classes' view
        return $this->render('continue-classes', [
            'dataProvider' => $dataProvider,
            'course' => $course,
        ]);
    }

    /**
     * Displays a single Courses model.
     * @param int $COURSE_ID Course ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($COURSE_ID)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($COURSE_ID),
        ]);
    }

    /**
     * Creates a new Courses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Courses();

        if ($this->request->isPost) {
            //start of file upload implementation
            // Handle the file upload using the helper
            $model->imageFile = UploadedFile::getInstance($model, 'IMAGE');

            if ($model->imageFile) {
                // Validate the file type (e.g., allow only images)
                if (FileHelper::validateFileType($model->imageFile, ['image/jpeg', 'image/jfif', 'image/png'])) {
                    // Save the file using the helper
                    $fileName = FileHelper::saveFile($model->imageFile);

                    if ($fileName) {
                        // Save the file name in the database
                        $model->IMAGE = $fileName;
                    } else {
                        Yii::$app->session->setFlash('error', 'File upload failed.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Invalid file type.');
                }
            }
            //end of file upload implementation
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Course added successfully.');

                return $this->redirect(['index', 'COURSE_ID' => $model->COURSE_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Courses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $COURSE_ID Course ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($COURSE_ID)
    {
        $model = $this->findModel($COURSE_ID);
        $oldImage = $model->IMAGE; // Store the current image path

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Handle the file upload using the helper
                $model->imageFile = UploadedFile::getInstance($model, 'IMAGE');

                if ($model->imageFile) {
                    // Validate the file type (e.g., allow only images)
                    if (FileHelper::validateFileType($model->imageFile, ['image/jpeg', 'image/jfif', 'image/png'])) {
                        // Save the file using the helper
                        $fileName = FileHelper::saveFile($model->imageFile);

                        if ($fileName) {
                            // Save the file name in the database
                            $model->IMAGE = $fileName;

                            // Optionally delete the old image file if it exists
                            if ($oldImage && file_exists(Yii::getAlias('@webroot') . '/' . $oldImage)) {
                                unlink(Yii::getAlias('@webroot') . '/' . $oldImage);
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'File upload failed.');
                            $model->IMAGE = $oldImage; // Revert to the old image if upload fails
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Invalid file type.');
                        $model->IMAGE = $oldImage; // Revert to the old image if type is invalid
                    }
                } else {
                    // If no new image is uploaded, retain the old image
                    $model->IMAGE = $oldImage;
                }

                // Save the model data after setting the correct image path
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Course updated successfully.');
                    return $this->redirect(['index', 'COURSE_ID' => $model->COURSE_ID]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Courses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $COURSE_ID Course ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($COURSE_ID)
    {
        $this->findModel($COURSE_ID)->delete();
        Yii::$app->session->setFlash('danger', 'Course deleted successfully.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Courses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $COURSE_ID Course ID
     * @return Courses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($COURSE_ID)
    {
        if (($model = Courses::findOne(['COURSE_ID' => $COURSE_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}