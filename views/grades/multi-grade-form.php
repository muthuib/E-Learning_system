<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Submissions;
use app\models\Grades;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Add Multiple Grades';
?>

<div class="grades-multiple-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['grades/save-multiple'], 'method' => 'post']); ?>

    <?php
    // Get all submissions that do not have grades
    $submissionsWithoutGrades = Submissions::find()
        ->leftJoin('grades', 'grades.SUBMISSION_ID = submissions.SUBMISSION_ID')
        ->where(['grades.SUBMISSION_ID' => null])
        ->all();
    ?>

    <?php if (!empty($submissionsWithoutGrades)) : ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Assignment Title</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissionsWithoutGrades as $submission) : ?>
            <tr>
                <td><?= Html::encode($submission->uSER->FIRST_NAME . ' ' . $submission->uSER->LAST_NAME) ?></td>
                <td><?= Html::encode($submission->aSSIGNMENT->TITLE) ?></td>
                <td>
                    <?= Html::hiddenInput("Grades[{$submission->SUBMISSION_ID}][SUBMISSION_ID]", $submission->SUBMISSION_ID) ?>
                    <?= Html::input('text', "Grades[{$submission->SUBMISSION_ID}][GRADE]", '', ['class' => 'form-control', 'placeholder' => 'Enter grade']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else : ?>
    <p>No ungraded submissions available.</p>
    <?php endif; ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save Grades', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['grades/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>