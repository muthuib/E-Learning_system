<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\GradesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="grades-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'GRADE_ID') ?>

    <?= $form->field($model, 'SUBMISSION_ID') ?>

    <?= $form->field($model, 'GRADE') ?>

    <?= $form->field($model, 'GRADED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
