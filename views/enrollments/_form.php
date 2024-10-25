<?php

use app\models\Courses;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Enrollments $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="enrollments-form">

    <?php $form = ActiveForm::begin(['id' => 'enrollment-form']); ?>

    <?= $form->field($model, 'USER_ID')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

    <!-- Dropdown for Course ID -->
    <?= $form->field($model, 'COURSE_ID')->dropDownList([], ['id' => 'course-id-dropdown', 'prompt' => 'Select Course']) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Enroll' : 'Update Enrollment',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <?= Html::a('Back', ['courses/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!-- Add the AJAX script here -->
<!-- Ensures that only courses which are not enrolled by the logged-in user are available in the dropdown -->
<?php
$script = <<< JS
$(document).ready(function () {
    // Load available courses automatically when the page is ready
    $.ajax({
        url: 'get-available-courses', // Adjust the URL to your actual action
        method: 'GET',
        success: function (data) {
            $('#course-id-dropdown').empty(); // Clear existing options
            $('#course-id-dropdown').append('<option value="">Select Course</option>');
            $.each(data, function (id, name) {
                $('#course-id-dropdown').append('<option value="' + id + '">' + name + '</option>');
            });
        }
    });

    // Add form submit handler
    $('#enrollment-form').on('beforeSubmit', function (e) {
        // Check if the selected value is null (or empty)
        if ($('#course-id-dropdown').val() === '') {
            // Prevent form submission
            e.preventDefault();
            // Display the alert message
            alert('Please select a course.');
            return false; // Stop further processing
        }
        return true; // Allow form submission
    });
});
JS;
$this->registerJs($script);
?>