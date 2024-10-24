<?php

namespace app\controllers;

use app\models\CourseCategories;
use app\models\search\CourseCategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseCategoriesController implements the CRUD actions for CourseCategories model.
 */
class CourseCategoriesController extends Controller
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
     * Lists all CourseCategories models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CourseCategoriesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourseCategories model.
     * @param int $COURSE_ID Course ID
     * @param int $CATEGORY_ID Category ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($COURSE_ID, $CATEGORY_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($COURSE_ID, $CATEGORY_ID),
        ]);
    }

    /**
     * Creates a new CourseCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CourseCategories();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'COURSE_ID' => $model->COURSE_ID, 'CATEGORY_ID' => $model->CATEGORY_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CourseCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $COURSE_ID Course ID
     * @param int $CATEGORY_ID Category ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($COURSE_ID, $CATEGORY_ID)
    {
        $model = $this->findModel($COURSE_ID, $CATEGORY_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'COURSE_ID' => $model->COURSE_ID, 'CATEGORY_ID' => $model->CATEGORY_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CourseCategories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $COURSE_ID Course ID
     * @param int $CATEGORY_ID Category ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($COURSE_ID, $CATEGORY_ID)
    {
        $this->findModel($COURSE_ID, $CATEGORY_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CourseCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $COURSE_ID Course ID
     * @param int $CATEGORY_ID Category ID
     * @return CourseCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($COURSE_ID, $CATEGORY_ID)
    {
        if (($model = CourseCategories::findOne(['COURSE_ID' => $COURSE_ID, 'CATEGORY_ID' => $CATEGORY_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
