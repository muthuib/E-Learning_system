<?php

use yii\helpers\Html;
use app\models\Courses;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Lessons $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lessons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
   // Get the logged-in user’s role
$isAdmin = Yii::$app->user->can('admin');

// If the user is an admin, fetch all courses; otherwise, fetch only the courses assigned to the instructor
if ($isAdmin) {
    $courses = Courses::find()->all();
} else {
    $instructorId = Yii::$app->user->identity->ID;
    $courses = Courses::find()->where(['instructor_id' => $instructorId])->all();
}

// Generate the dropdown list with the appropriate courses
echo $form->field($model, 'COURSE_ID')->dropDownList(
    ArrayHelper::map($courses, 'COURSE_ID', 'COURSE_NAME'),
    ['prompt' => 'Select Course']
);
    ?>

    <?= $form->field($model, 'TITLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONTENT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'VIDEO_URL')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Add Lesson' : 'Update Lesson',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>