<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Categories $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CATEGORY_NAME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Add category' : 'Update category',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>