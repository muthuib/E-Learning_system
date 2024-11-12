<?php

use app\models\Courses;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Assignments $model */
/** @var yii\widgets\ActiveForm $form */

$userId = Yii::$app->user->id; // Get the currently logged-in user ID

// Check if the user is an admin or instructor
if (Yii::$app->user->can('admin')) {
    // If the user is an admin, fetch all courses
    $assignedCourses = Courses::find()->all();
} elseif (Yii::$app->user->can('instructor')) {
    // If the user is an instructor, fetch the courses assigned to the current instructor
    $assignedCourses = Courses::find()
        ->where(['INSTRUCTOR_ID' => $userId]) // Adjust the condition as per your model
        ->all();
}
?>

<div class="assignments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!empty($assignedCourses)): ?>
    <?= $form->field($model, 'COURSE_ID')->dropDownList(
            ArrayHelper::map($assignedCourses, 'COURSE_ID', 'COURSE_NAME'),
            ['prompt' => 'Select Course', 'required' => true]
        ) ?>
    <?php else: ?>
    <div class="alert alert-warning">
        No courses assigned to you. So you can't Add an Assignment.
    </div>
    <?= $form->field($model, 'COURSE_ID')->hiddenInput()->label(false); // Keep it in the model but hidden 
        ?>
    <?php endif; ?>

    <?= $form->field($model, 'TITLE')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'TOTAL_MARKS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'DUE_DATE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Add Assignment' : 'Update Assignment',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>