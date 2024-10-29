<?php

namespace app\controllers;

use Yii;
use app\models\Grades;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\search\GradesSearch;

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
     * Lists all submissions to allow muiltiple grades.
     *
     * @return string
     */
    public function actionMultiGradeForm()
    {
        $model = new Grades(); // Initialize model if needed
        return $this->render('multi-grade-form', [
            'model' => $model,
        ]);
    }

    /**
     *  adds and saves muiltple grades.
     *
     * @return string
     */
    public function actionSaveMultiple()
    {
        if (Yii::$app->request->post('Grades')) {
            $gradesData = Yii::$app->request->post('Grades');

            foreach ($gradesData as $gradeData) {
                $grade = new Grades();
                $grade->SUBMISSION_ID = $gradeData['SUBMISSION_ID'];
                $grade->GRADE = $gradeData['GRADE'];
                $grade->GRADED_AT = date('Y-m-d H:i:s');
                $grade->save();
            }

            Yii::$app->session->setFlash('success', 'Grades saved successfully.');
            return $this->redirect(['submissions/index']);
        }
        return $this->redirect(['grades/multi-grade-form']);
    }
    /**
     *  selects and deletes muiltple grades.
     *
     * @return string
     */
    public function actionDeleteMultiple()
    {
        $gradeIds = Yii::$app->request->post('selection', []);
        if (!empty($gradeIds)) {
            Grades::deleteAll(['GRADE_ID' => $gradeIds]);
            Yii::$app->session->setFlash('success', 'Selected grades have been deleted.');
        } else {
            Yii::$app->session->setFlash('error', 'No grades selected.');
        }
        return $this->redirect(['grades/index']);
    }
    /**
     *  selects and edits muiltple grades.
     *
     * @return string
     */
    public function actionEditMultiple($ids)
    {
        $gradeIds = explode(',', $ids);
        $grades = Grades::findAll(['GRADE_ID' => $gradeIds]);

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Grades');
            foreach ($grades as $grade) {
                $grade->GRADE = $postData[$grade->GRADE_ID]['GRADE'];
                $grade->save();
            }
            Yii::$app->session->setFlash('success', 'Grades have been updated.');
            return $this->redirect(['index']);
        }

        return $this->render('edit-multiple', [
            'grades' => $grades,
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
                Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Grade added successfully.');
                return $this->redirect(['submissions/index', 'GRADE_ID' => $model->GRADE_ID]);
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
            Yii::$app->session->setFlash('success', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Grade updated successfully.');
            return $this->redirect(['submissions/index', 'GRADE_ID' => $model->GRADE_ID]);
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
        Yii::$app->session->setFlash('danger', '<i class="bi bi-check-circle me-2" style="font-size: 1.5rem;"></i> Grade deleted successfully.');

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