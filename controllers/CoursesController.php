<?php

namespace app\controllers;

use app\models\Courses;
use app\models\search\CoursesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Course updated successfully.');


            return $this->redirect(['index', 'COURSE_ID' => $model->COURSE_ID]);
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