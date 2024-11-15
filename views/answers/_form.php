<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Answers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="answers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'QUESTION_ID')->textInput() ?>

    <?= $form->field($model, 'CONTENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IS_CORRECT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
