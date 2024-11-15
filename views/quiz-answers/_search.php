<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\QuizAnswersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quiz-answers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'QUIZ_ID') ?>

    <?= $form->field($model, 'QUESTION_ID') ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'ANSWER_TYPE') ?>

    <?php // echo $form->field($model, 'ANSWER') ?>

    <?php // echo $form->field($model, 'USER_ANSWER') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
