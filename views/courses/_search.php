<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\CoursesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="courses-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'COURSE_ID') ?>

    <?= $form->field($model, 'COURSE_NAME') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?= $form->field($model, 'INSTRUCTOR_ID') ?>

    <?= $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
