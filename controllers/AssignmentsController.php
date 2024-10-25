<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Assignments;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\search\AssignmentsSearch;

/**
 * AssignmentsController implements the CRUD actions for Assignments model.
 */
class AssignmentsController extends Controller
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
     * Lists all Assignments models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AssignmentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assignments model.
     * @param int $ASSIGNMENT_ID Assignment ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ASSIGNMENT_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ASSIGNMENT_ID),
        ]);
    }

    /**
     * Creates a new Assignments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Assignments();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Assigment Added successfully.');
                return $this->redirect(['index', 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Assignments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ASSIGNMENT_ID Assignment ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ASSIGNMENT_ID)
    {
        $model = $this->findModel($ASSIGNMENT_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Assignment updated successfully.');
            return $this->redirect(['index', 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Assignments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ASSIGNMENT_ID Assignment ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ASSIGNMENT_ID)
    {
        $this->findModel($ASSIGNMENT_ID)->delete();
        Yii::$app->session->setFlash('danger', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Assignment deleted successfully.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Assignments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ASSIGNMENT_ID Assignment ID
     * @return Assignments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ASSIGNMENT_ID)
    {
        if (($model = Assignments::findOne(['ASSIGNMENT_ID' => $ASSIGNMENT_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}