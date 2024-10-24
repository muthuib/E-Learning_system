<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\SubmissionsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="submissions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SUBMISSION_ID') ?>

    <?= $form->field($model, 'ASSIGNMENT_ID') ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'FILE_URL') ?>

    <?= $form->field($model, 'SUBMITTED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
