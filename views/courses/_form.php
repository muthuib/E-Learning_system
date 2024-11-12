<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;


/** @var yii\web\View $this */
/** @var app\models\Courses $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="courses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'COURSE_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?php
    // Check if the current user is an instructor or admin based on RBAC
    if (Yii::$app->user->can('instructor')) {
        // Pre-fill the instructor ID since the current user is an instructor
        $instructorId = Yii::$app->user->id; // Get the logged-in user's ID
        echo $form->field($model, 'INSTRUCTOR_ID')->hiddenInput(['value' => $instructorId])->label(false);
    } elseif (Yii::$app->user->can('admin')) {
        // If the current user is an admin, show a dropdown to select an instructor
        $instructors = User::find()->joinWith('authAssignments')
            ->where(['auth_assignment.item_name' => 'instructor'])
            ->all(); // Fetch all users with the "instructor" role
        $instructorList = ArrayHelper::map($instructors, 'ID', function ($instructor) {
            return $instructor['FIRST_NAME'] . ' ' . $instructor['LAST_NAME'];
        }); // Map ID to the instructor's NAMES
        echo $form->field($model, 'INSTRUCTOR_ID')->dropDownList($instructorList, ['prompt' => 'Select Instructor']);
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Add course' : 'Update course',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>