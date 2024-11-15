<?php

use app\models\QuizAnswers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\QuizAnswersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Quiz Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-answers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Quiz Answers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'QUIZ_ID',
            'QUESTION_ID',
            'USER_ID',
            'ANSWER_TYPE',
            'ANSWER:ntext',
            'USER_ANSWER:ntext',
            //'CREATED_AT',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, QuizAnswers $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>


</div>