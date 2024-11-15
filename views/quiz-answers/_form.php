<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\QuizAnswers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quiz-answers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput() ?>

    <?= $form->field($model, 'QUIZ_ID')->textInput() ?>

    <?= $form->field($model, 'QUESTION_ID')->textInput() ?>

    <?= $form->field($model, 'USER_ID')->textInput() ?>

    <?= $form->field($model, 'ANSWER_TYPE')->dropDownList([ 'radio' => 'Radio', 'checkbox' => 'Checkbox', 'text' => 'Text', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ANSWER')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'USER_ANSWER')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
