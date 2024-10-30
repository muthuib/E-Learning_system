<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Assignments;
use app\models\Submissions;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\search\SubmissionsSearch;

/**
 * SubmissionsController implements the CRUD actions for Submissions model.
 */
class SubmissionsController extends Controller
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
    }

    /**
     * Lists all Submissions models.
     *
     * @return string
     */
    public function actionIndex($assignmentId = null)
    {
        $searchModel = new SubmissionsSearch();
        $query = Submissions::find();

        // Filter submissions by assignment if assignmentId is provided
        if ($assignmentId !== null) {
            $query->andWhere(['ASSIGNMENT_ID' => $assignmentId]);
        }

        // Check if the user is a student and restrict submissions to their own
        if (Yii::$app->user->can('student')) {
            $query->andWhere(['USER_ID' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'assignmentId' => $assignmentId, // Pass assignmentId to the view
        ]);
    }

    /**
     * Displays a single Submissions model.
     * @param int $SUBMISSION_ID Submission ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($SUBMISSION_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($SUBMISSION_ID),
        ]);
    }

    /**
     * Creates a new Submissions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Submissions();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Submissions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $SUBMISSION_ID Submission ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($SUBMISSION_ID)
    {
        $model = $this->findModel($SUBMISSION_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Submissions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $SUBMISSION_ID Submission ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($SUBMISSION_ID)
    {
        $this->findModel($SUBMISSION_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Submissions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $SUBMISSION_ID Submission ID
     * @return Submissions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($SUBMISSION_ID)
    {
        if (($model = Submissions::findOne(['SUBMISSION_ID' => $SUBMISSION_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    ///function to submit an assignment
    //makes sure that both Assignments and Submissions models are loaded and passed to the view
    public function actionSubmit($id)
    {
        // Load the assignment model based on the provided assignment ID
        $assignmentModel = Assignments::findOne($id);
        if (!$assignmentModel) {
            throw new NotFoundHttpException('The requested assignment does not exist.');
        }

        // Create a new submission model
        $submissionModel = new Submissions();

        // Handle form submission
        if ($submissionModel->load(Yii::$app->request->post())) {
            $submissionModel->ASSIGNMENT_ID = $assignmentModel->ASSIGNMENT_ID; // Link to the assignment
            $submissionModel->USER_ID = Yii::$app->user->id; // Current user ID
            $submissionModel->SUBMITTED_AT = date('Y-m-d H:i:s'); // Submission time

            // Handle file upload
            // $file = UploadedFile::getInstance($submissionModel, 'FILE_URL');
            // if ($file) {
            //     $filePath = 'uploads/' . $file->baseName . '.' . $file->extension;
            //     if ($file->saveAs($filePath)) {
            //         $submissionModel->FILE_URL = $filePath;
            //     }
            // }

            // Save the submission to the database
            if ($submissionModel->save()) {
                Yii::$app->session->setFlash('success', 'Assignment submitted successfully!');
                return $this->redirect(['index']);
            }
        }

        // Render the form view with assignment and submission models
        return $this->render('submit', [
            'assignmentModel' => $assignmentModel,
            'submissionModel' => $submissionModel,
        ]);
    }

}