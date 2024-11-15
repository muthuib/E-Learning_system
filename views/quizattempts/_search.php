<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\QuizAttemptsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quiz-attempts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'QUIZ_ID') ?>

    <?= $form->field($model, 'START_TIME') ?>

    <?= $form->field($model, 'END_TIME') ?>

    <?php // echo $form->field($model, 'SCORE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
