<?php

namespace app\controllers;

use app\models\Submissions;
use app\models\search\SubmissionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
    public function actionIndex()
    {
        $searchModel = new SubmissionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
}
