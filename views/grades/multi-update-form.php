<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Submissions;
use app\models\Grades;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Update Multiple Grades'; // Title of the form
?>

<div class="grades-multiple-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['grades/update-multiple'], 'method' => 'post']); ?>

    <?php
    // Get all submissions that have grades for editing
    $submissionsWithGrades = Submissions::find()
        ->joinWith('grades') // Ensure to join with the Grades table
        ->where(['NOT', ['grades.SUBMISSION_ID' => null]])
        ->all();
    ?>

    <?php if (!empty($submissionsWithGrades)) : ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th> <!-- Index column header -->
                <th>Student Name</th>
                <th>Assignment Title</th>
                <th>Current Grade</th>
                <th>Edit Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissionsWithGrades as $index => $submission) : ?>
            <tr>
                <td><?= $index + 1 ?></td> <!-- Display the index (starting from 1) -->
                <td><?= Html::encode($submission->uSER->FIRST_NAME . ' ' . $submission->uSER->LAST_NAME) ?></td>
                <td><?= Html::encode($submission->aSSIGNMENT->TITLE) ?></td>
                <!-- Display current grade -->
                <td>
                    <?php
                            $grades = $submission->grades;
                            if ($grades && is_array($grades)) {
                                foreach ($grades as $grade) {
                                    echo Html::tag('span', Html::encode($grade->GRADE), ['style' => 'color: darkblue; font-weight: bold;']);
                                    echo '<br>'; // Line break for readability
                                }
                            } else {
                                echo 'N/A'; // If no grade found
                            }
                            ?>
                </td>
                <td>
                    <?= Html::hiddenInput("Grades[{$submission->SUBMISSION_ID}][SUBMISSION_ID]", $submission->SUBMISSION_ID) ?>
                    <?= $form->field($grade ?: new Grades(), "[$submission->SUBMISSION_ID]GRADE", [
                                'options' => ['class' => 'form-group'],
                            ])->textInput([
                                'class' => 'form-control',
                                'placeholder' => 'Edit grade',
                                'type' => 'number', // Set type to number
                                'step' => 'any', // Allows decimal values
                                'min' => 0, // Optional: minimum value
                            ])->label(false)->error(['class' => 'text-danger']); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else : ?>
    <p>No graded submissions available for editing.</p>
    <?php endif; ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Update Grades', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['grades/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>