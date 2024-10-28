<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Grades $model */
/** @var yii\widgets\ActiveForm $form */

//when a user clicks the button from the submissions index, you can modify the form to receive the SUBMISSION_ID as a parameter. This way, when the form is rendered, it will display the correct submission ID without requiring the user to enter it manually.
//pick the Submission id of thet particular submission automaticaly
// Check if SUBMISSION_ID is set in the query parameters and set it to the model, If it is, it assigns that value to the SUBMISSION_ID attribute of the $model.
if (isset($_GET['SUBMISSION_ID'])) {
    $model->SUBMISSION_ID = $_GET['SUBMISSION_ID'];
}
?>

<div class="grades-form">

    <?php $form = ActiveForm::begin(); ?>
    <!-- Dont remove this input field for submission, otherwise the form will not pick the submission id automatically -->
    <?= $form->field($model, 'SUBMISSION_ID')->hiddenInput(['readonly' => true]) ?>
    <?= $form->field($model, 'GRADE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Add Grade' : 'Update Grade',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <?= Html::a('Back', ['submissions/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>