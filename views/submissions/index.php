<?php

use app\models\Submissions;
use app\models\Grades;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Submissions'; // Set the title for the page
?>
<div class="submissions-index">

    <h1><?= Html::encode($this->title) ?></h1> <!-- Display the title -->

    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
    <div class="text-end mb-3">
        <!-- Button to add a new submission (only visible to admin and instructor) -->
        <?= Html::a('Add Submission', ['submissions/create'], ['class' => 'btn btn-primary']) ?>
    </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <!-- Start of the table -->
        <thead>
            <tr>
                <th>#</th> <!-- Index number -->
                <th>Assignment Title</th> <!-- Title of the assignment -->
                <th>Student Name</th> <!-- Name of the student -->
                <th>User Email</th> <!-- Email of the user -->
                <th>Content</th> <!-- Submission content -->
                <th>File URL</th> <!-- URL of the submitted file -->
                <th>Submitted At</th> <!-- Date and time of submission -->
                <th>Grade</th> <!-- New Grade Column -->
                <th>Actions</th> <!-- Column for action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->getModels() as $index => $model): ?>
            <tr>
                <td><?= $index + 1 ?></td> <!-- Display row index -->
                <td><?= Html::encode($model->aSSIGNMENT->TITLE) ?></td> <!-- Display assignment title -->
                <td>
                    <?php
                        // Retrieve the student's user information
                        $user = User::findOne($model->USER_ID);
                        echo Html::encode($user ? $user->FIRST_NAME . ' ' . $user->LAST_NAME : 'N/A'); // Display student name
                        ?>
                </td>
                <td><?= Html::encode($user ? $user->EMAIL : 'N/A') ?></td> <!-- Display user email -->
                <td>
                    <?php
                        // Shorten the content for display
                        $contentWords = explode(' ', strip_tags($model->CONTENT)); // Split content into words
                        $shortContent = implode(' ', array_slice($contentWords, 0, 20)); // Show first 20 words
                        ?>
                    <?= Html::encode($shortContent) ?>
                    <!-- Display shortened content -->
                    <?php if (count($contentWords) > 20): ?>
                    ... <a href="<?= Url::to(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>">Read More</a>
                    <!-- Link to read more -->
                    <?php endif; ?>
                </td>
                <td>
                    <!-- Link to the submitted file -->
                    <a href="<?= Url::to($model->FILE_URL) ?>" target="_blank"><?= Html::encode($model->FILE_URL) ?></a>
                </td>
                <td><?= Html::encode($model->SUBMITTED_AT) ?></td> <!-- Display submission date -->
                <td>
                    <?php
                        // Check if a grade exists for the submission
                        $grade = Grades::find()->where(['SUBMISSION_ID' => $model->SUBMISSION_ID])->one();
                        if ($grade) {
                            // Display the grade with custom styling
                            echo Html::tag('span', Html::encode($grade->GRADE), ['style' => 'color: darkblue; font-weight: bold;']); // Dark blue and bold
                            // Show Edit Grade button only for admins and instructors
                            if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')) {
                                echo ' ';
                                // Group the buttons together
                                echo '<div class="btn-group" role="group">';
                                echo Html::a('Edit Grade', ['grades/update', 'GRADE_ID' => $grade->GRADE_ID], [
                                    'class' => 'btn btn-warning btn-sm',
                                    'title' => 'Edit Grade for this Submission' // Tooltip for the button
                                ]);
                                echo '</div>';
                            }
                        } else {
                            // Display "Not graded" with custom styling
                            echo Html::tag('span', 'Not graded', ['style' => 'color: purple; font-weight: bold; font-size: 15px;']); // Purple color
                            if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')) {
                                echo ' ';
                                // Button to add a grade (only visible to admins and instructors)
                                echo '<div class="btn-group" role="group">';
                                echo Html::a('Add Grade', ['grades/create', 'SUBMISSION_ID' => $model->SUBMISSION_ID], [
                                    'class' => 'btn btn-success btn-sm',
                                    'title' => 'Add Grade for this Submission' // Tooltip for the button
                                ]);
                                echo '</div>';
                            }
                        }
                        ?>
                </td>
                <td>
                    <div class="d-flex">
                        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
                        <!-- Action buttons for admins and instructors -->
                        <a href="<?= Url::to(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-info btn-sm">View</a>
                        <a href="<?= Url::to(['update', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-primary btn-sm">Update</a>
                        <?= Html::a('Delete', ['delete', 'SUBMISSION_ID' => $model->SUBMISSION_ID], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this submission?',
                                        'method' => 'post', // Use POST method for deletion
                                    ],
                                ]) ?>
                        <?php elseif (Yii::$app->user->can('student')): ?>
                        <!-- Action button for students -->
                        <a href="<?= Url::to(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-info btn-sm">View</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>