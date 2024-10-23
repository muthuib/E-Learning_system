<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\AssignmentsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="assignments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ASSIGNMENT_ID') ?>

    <?= $form->field($model, 'COURSE_ID') ?>

    <?= $form->field($model, 'TITLE') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?= $form->field($model, 'DUE_DATE') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
