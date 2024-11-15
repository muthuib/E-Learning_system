<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuizAttempts $model */

$this->title = 'Update Quiz Attempts: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Quiz Attempts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-attempts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
