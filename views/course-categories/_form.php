<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CourseCategories $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="course-categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'COURSE_ID')->textInput() ?>

    <?= $form->field($model, 'CATEGORY_ID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
