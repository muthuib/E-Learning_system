<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Assignments $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="assignments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'COURSE_ID')->textInput() ?>

    <?= $form->field($model, 'TITLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'DUE_DATE')->textInput() ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
