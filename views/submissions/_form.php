<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Submissions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="submissions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ASSIGNMENT_ID')->textInput() ?>

    <?= $form->field($model, 'USER_ID')->textInput() ?>

    <?= $form->field($model, 'FILE_URL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SUBMITTED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
