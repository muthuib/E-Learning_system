<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuizAnswers $model */

$this->title = 'Create Quiz Answers';
$this->params['breadcrumbs'][] = ['label' => 'Quiz Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-answers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
