<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Grades $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="grades-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SUBMISSION_ID')->textInput() ?>

    <?= $form->field($model, 'GRADE')->textInput() ?>

    <?= $form->field($model, 'GRADED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
