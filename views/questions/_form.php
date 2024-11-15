<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Questions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- QUIZ_ID field (can be auto-generated or manually selected) -->
    <?= $form->field($model, 'QUIZ_ID')->textInput(['readonly' => false]) ?>

    <!-- Question content field -->
    <?= $form->field($model, 'CONTENT')->textarea(['rows' => 6]) ?>

    <!-- Answer type field: Radio, Checkbox, or Text input -->
    <?= $form->field($model, 'ANSWER_TYPE')->dropDownList([
        'radio' => 'Radio Selection (Single Choice)',
        'checkbox' => 'Checkbox (Multiple Choice)',
        'text' => 'Text Input (Typing Answer)'
    ], [
        'prompt' => 'Select Answer Type',
        'onchange' => 'toggleAnswerOptions(this.value)'
    ]) ?>

    <!-- Answer options input field (initially hidden) -->
    <div id="answer-options" style="display: none;">
        <label>Answer Options (Enter each option on a new line):</label>
        <?= Html::textarea('AnswerOptions', '', [
            'rows' => 4,
            'placeholder' => 'Enter each option on a new line',
            'style' => 'width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;'
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
// Show or hide the answer options field based on the selected answer type
function toggleAnswerOptions(answerType) {
    const answerOptions = document.getElementById('answer-options');
    if (answerType === 'radio' || answerType === 'checkbox') {
        answerOptions.style.display = 'block'; // Show answer options
    } else {
        answerOptions.style.display = 'none'; // Hide answer options
    }
}
</script>