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
                <th>#</th> <!-- Index number -->
                <th>Student Name</th>
                <th>Assignment Title</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissionsWithoutGrades as $index => $submission) : ?>
            <tr>
                <td><?= $index + 1 ?></td> <!-- Display row index -->
                <td><?= Html::encode($submission->uSER->FIRST_NAME . ' ' . $submission->uSER->LAST_NAME) ?></td>
                <td><?= Html::encode($submission->aSSIGNMENT->TITLE) ?></td>
                <td>
                    <?= Html::hiddenInput("Grades[{$submission->SUBMISSION_ID}][SUBMISSION_ID]", $submission->SUBMISSION_ID) ?>
                    <?= Html::input('number', "Grades[{$submission->SUBMISSION_ID}][GRADE]", '', [
                                'class' => 'form-control' . (isset($errors[$submission->SUBMISSION_ID]) ? ' is-invalid' : ''), // Add 'is-invalid' class for Bootstrap
                                'placeholder' => 'Enter grade',
                                'step' => 'any',
                                'min' => 0,
                                'required' => true,
                                'id' => "grade-input-{$submission->SUBMISSION_ID}",
                            ]) ?>

                    <!-- Display error message if errors exist -->
                    <?php if (isset($errors[$submission->SUBMISSION_ID])) : ?>
                    <div class="text-danger">
                        <?= implode(', ', $errors[$submission->SUBMISSION_ID][0]) ?>
                        <!-- Display the first error message -->
                    </div>
                    <?php endif; ?>
                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else : ?>
    <p>No ungraded submissions available.</p>
    <?php endif; ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Add Grades', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['grades/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>