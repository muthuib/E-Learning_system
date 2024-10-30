<?php


use yii\helpers\Html;
use app\models\Assignments;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Submissions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="submissions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ASSIGNMENT_ID')->dropDownList(ArrayHelper::map(Assignments::find()->all(), 'ASSIGNMENT_ID', 'TITLE'), ['prompt' => 'Select Assignment']) ?>

    <?= $form->field($model, 'USER_ID')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

    <?= $form->field($model, 'FILE_URL')->textInput(['maxlength' => true]) ?>

    <!-- Add the CONTENT field -->
    <?= $form->field($model, 'CONTENT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'SUBMITTED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Add Submission' : 'Update Submission',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <a href="<?= Url::to(['submissions/index', 'assignmentId' => $model->ASSIGNMENT_ID]) ?>"
            class="btn btn-info btn-sm">BACK</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>