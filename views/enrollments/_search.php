<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\EnrollmentsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="enrollments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ENROLLMENT_ID') ?>

    <?= $form->field($model, 'USER_ID') ?>

    <?= $form->field($model, 'COURSE_ID') ?>

    <?= $form->field($model, 'ENROLLED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
