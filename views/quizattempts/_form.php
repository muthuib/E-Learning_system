<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\QuizAttempts $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quiz-attempts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'USER_ID')->textInput() ?>

    <?= $form->field($model, 'QUIZ_ID')->textInput() ?>

    <?= $form->field($model, 'START_TIME')->textInput() ?>

    <?= $form->field($model, 'END_TIME')->textInput() ?>

    <?= $form->field($model, 'SCORE')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
