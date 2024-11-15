<?php

use app\models\QuizAttempts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\QuizAttemptsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Quiz Attempts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-attempts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Quiz Attempts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'USER_ID',
            'QUIZ_ID',
            'START_TIME',
            'END_TIME',
            //'SCORE',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, QuizAttempts $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>


</div>
