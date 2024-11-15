<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuizAttempts $model */

$this->title = 'Create Quiz Attempts';
$this->params['breadcrumbs'][] = ['label' => 'Quiz Attempts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-attempts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
