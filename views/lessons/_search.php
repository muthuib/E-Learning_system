<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\LessonsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lessons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'LESSON_ID') ?>

    <?= $form->field($model, 'COURSE_ID') ?>

    <?= $form->field($model, 'TITLE') ?>

    <?= $form->field($model, 'CONTENT') ?>

    <?= $form->field($model, 'VIDEO_URL') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
