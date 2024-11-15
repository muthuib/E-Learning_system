<?php

namespace app\controllers;

use Yii;
use app\models\Answers;
use app\models\Quizzes;
use yii\web\Controller;
use app\models\Questions;
use app\models\QuizAnswers;
use yii\filters\VerbFilter;
use app\models\QuizAttempts;
use yii\web\NotFoundHttpException;
use app\models\search\QuizzesSearch;
use yii\web\BadRequestHttpException;
use Symfony\Component\Console\Question\Question;
use yii\web\Response; // <-- This import is needed for Response class

/**
 * QuizzesController implements the CRUD actions for Quizzes model.
 */
class QuizzesController extends Controller
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
     * Lists all Quizzes models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $quizzes = Quizzes::find()->all();  // Get all quizzes
        return $this->render('index', ['quizzes' => $quizzes]);
    }

public function actionList()
{
    // Fetch all quizzes for the sidebar or listing page
    $quizzes = Quizzes::find()->all();

    return $this->render('list', [
        'quizzes' => $quizzes, // Pass all quizzes to the view
    ]);
}

    public function actionStartQuiz($id)
    {
        $quiz = Quizzes::findOne($id);
        $userId = Yii::$app->user->id;  // Get the current user's ID

        if ($quiz) {
            // Create a new quiz attempt
            $quizAttempt = new QuizAttempts();
            $quizAttempt->USER_ID = $userId;
            $quizAttempt->QUIZ_ID = $quiz->ID;
            $quizAttempt->START_TIME = new \yii\db\Expression('NOW()');
            $quizAttempt->save();

            // Redirect to the quiz view page where they can start answering questions
            return $this->redirect(['quizzes/view', 'id' => $quiz->ID]);
        } else {
            throw new NotFoundHttpException('Quiz not found.');
        }
    }

    
   public function actionSubmitQuiz($id)
{
    $quiz = Quizzes::findOne($id);
    if (!$quiz) {
        return $this->asJson(['status' => 'error', 'message' => 'Quiz not found']);
    }

    // Process the submitted answers
    foreach (Yii::$app->request->post() as $questionId => $answerIds) {
        // Handle radio, checkbox, and text answers
        if (is_array($answerIds)) {
            // Handle multiple answers for checkboxes
            foreach ($answerIds as $answerId) {
                $this->saveAnswer($questionId, $answerId);
            }
        } else {
            // Handle single answer for radio or text
            $this->saveAnswer($questionId, $answerIds);
        }
    }

    return $this->asJson(['status' => 'success']);
}

private function saveAnswer($questionId, $answerId)
{
    $answer = new QuizAnswers();
    $answer->QUESTION_ID = $questionId;
    $answer->ANSWER_ID = $answerId;
    $answer->USER_ID = Yii::$app->user->id; // Assuming the user is logged in
    $answer->save();
}

    // Action to render quiz submitted page
    public function actionQuizsubmitted($id)
    {
        $quiz = Quizzes::findOne($id);

        if (!$quiz) {
            throw new NotFoundHttpException('Quiz not found.');
        }

        return $this->render('quizsubmitted', [
            'quiz' => $quiz
        ]);
    }
    //end of  the action
    public function actionResult($id)
    {
        $userId = Yii::$app->user->id;
        $quizAttempt = QuizAttempts::findOne(['USER_ID' => $userId, 'QUIZ_ID' => $id]);

        if ($quizAttempt) {
            return $this->render('quizsubmitted', ['quizAttempt' => $quizAttempt]);
        }

        throw new NotFoundHttpException('Quiz attempt not found.');
    }


    /**
     * Displays a single Quizzes model.
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $quiz = Quizzes::findOne($id);  // Get quiz by ID
        if (!$quiz) {
            throw new NotFoundHttpException('Quiz not found.');
        }

        $questions = Questions::find()->where(['QUIZ_ID' => $id])->all();  // Get questions for this quiz
        return $this->render('view', [
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }

    /**
     * Creates a new Quizzes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Quizzes();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'ID' => $model->ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Quizzes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Quizzes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ID ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID)
    {
        $this->findModel($ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Quizzes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return Quizzes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = Quizzes::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}