<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Quizzes $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quizzes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DURATION')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Add Quiz', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>