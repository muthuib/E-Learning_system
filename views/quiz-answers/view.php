<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\QuizAnswers $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Quiz Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quiz-answers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'QUIZ_ID',
            'QUESTION_ID',
            'USER_ID',
            'ANSWER_TYPE',
            'ANSWER:ntext',
            'USER_ANSWER:ntext',
            'CREATED_AT',
        ],
    ]) ?>

</div>
