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

    <?= $form->field($model, 'COURSE_ID')->dropDownList(ArrayHelper::map(Courses::find()->all(), 'COURSE_ID', 'COURSE_NAME'), ['prompt' => 'Select Course']) ?>

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