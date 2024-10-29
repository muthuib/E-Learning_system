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
                <th>Student Name</th>
                <th>Assignment Title</th>
                <th>Current Grade</th>
                <th>Edit Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissionsWithGrades as $submission) : ?>
            <tr>
                <td><?= Html::encode($submission->uSER->FIRST_NAME . ' ' . $submission->uSER->LAST_NAME) ?></td>
                <td><?= Html::encode($submission->aSSIGNMENT->TITLE) ?></td>
                <!-- Display current grade -->
                <td>
                    <?php
                            // Fetch the grade using the SUBMISSION_ID
                            $grade = Grades::find()->where(['SUBMISSION_ID' => $submission->SUBMISSION_ID])->one();
                            if ($grade) {
                                // Display the grade with custom styling
                                echo Html::tag('span', Html::encode($grade->GRADE), ['style' => 'color: darkblue; font-weight: bold;']);
                            } else {
                                echo 'N/A'; // If no grade found
                            }
                            ?>
                </td>

                <td>
                    <?= Html::hiddenInput("Grades[{$submission->SUBMISSION_ID}][SUBMISSION_ID]", $submission->SUBMISSION_ID) ?>
                    <?= Html::input('text', "Grades[{$submission->SUBMISSION_ID}][GRADE]", $submission->gRADes->GRADE ?? '', [
                                'class' => 'form-control',
                                'placeholder' => 'Edit grade'
                            ]) ?>
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