<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Submissions $submissionModel */
/** @var app\models\Assignments $assignmentModel */
?>
<!-- this file is a submit button implementation and to link to,,,its not like a normal _form.php -->
<!-- You cannot add this file directly to sidebar, you shout link it to your respective submit button so that you can get the formdisplayed  -->
<div class="assignment-submission-form">

    <h1>Assignment: <?= Html::encode($assignmentModel->TITLE) ?></h1>
    <p><strong>Description:</strong> <?= Html::encode($assignmentModel->DESCRIPTION) ?></p>
    <p><strong>Due Date:</strong> <?= Html::encode($assignmentModel->DUE_DATE) ?></p>

    <h2>Submit Your Answer</h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($submissionModel, 'ASSIGNMENT_ID')->hiddenInput(['value' => $assignmentModel->ASSIGNMENT_ID])->label(false) ?>
    <?= $form->field($submissionModel, 'USER_ID')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
    <?= $form->field($submissionModel, 'CONTENT')->textarea(['rows' => 6, 'placeholder' => 'Type your answer here...']) ?>
    <?= $form->field($submissionModel, 'FILE_URL')->fileInput() ?>
    <?= $form->field($submissionModel, 'SUBMITTED_AT')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit Assignment', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>