<?php

namespace app\controllers;

use app\models\Grades;
use app\models\search\GradesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GradesController implements the CRUD actions for Grades model.
 */
class GradesController extends Controller
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
     * Lists all Grades models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GradesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Grades model.
     * @param int $GRADE_ID Grade ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($GRADE_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($GRADE_ID),
        ]);
    }

    /**
     * Creates a new Grades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Grades();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'GRADE_ID' => $model->GRADE_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Grades model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $GRADE_ID Grade ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($GRADE_ID)
    {
        $model = $this->findModel($GRADE_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'GRADE_ID' => $model->GRADE_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Grades model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $GRADE_ID Grade ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($GRADE_ID)
    {
        $this->findModel($GRADE_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Grades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $GRADE_ID Grade ID
     * @return Grades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($GRADE_ID)
    {
        if (($model = Grades::findOne(['GRADE_ID' => $GRADE_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
