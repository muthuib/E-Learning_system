<?php

namespace app\controllers;

use Yii;
use app\models\Lessons;
use yii\web\Controller;
use yii\filters\VerbFilter;
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
     * Lists all Lessons models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LessonsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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