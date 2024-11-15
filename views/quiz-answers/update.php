<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuizAnswers $model */

$this->title = 'Update Quiz Answers: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Quiz Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-answers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
