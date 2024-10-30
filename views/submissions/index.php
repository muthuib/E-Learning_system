<?php

use app\models\Grades;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int|null $assignmentId */

$this->title = 'Submissions';
?>
<div class="submissions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <!-- Button to add a new submission (only visible to admin and instructor) -->
    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
    <div class="text-end mb-3">
        <?= Html::a('Add Submission', ['submissions/create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php endif; ?>

    <?php
    // Group submissions by assignment
    $submissions = $dataProvider->getModels();
    $groupedSubmissions = [];

    // Group each submission by its assignment ID
    foreach ($submissions as $submission) {
        $submissionAssignmentId = $submission->ASSIGNMENT_ID;
        $groupedSubmissions[$submissionAssignmentId][] = $submission;
    }
    ?>

    <!-- Loop through each assignment and create a clickable link to view its submissions -->
    <?php foreach ($groupedSubmissions as $submissionAssignmentId => $assignmentSubmissions): ?>
    <h3>
        <?= Html::a(
                Html::encode($assignmentSubmissions[0]->aSSIGNMENT->TITLE), // Assignment title
                ['index', 'assignmentId' => $submissionAssignmentId] // Link to filter submissions by assignmentId
            ) ?>
    </h3>
    <?php endforeach; ?>

    <!-- Display the table of submissions if an assignment has been selected by the user -->
    <?php if ($assignmentId !== null && isset($groupedSubmissions[$assignmentId])): ?>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>User Email</th>
                <th>Content</th>
                <th>File URL</th>
                <th>Submitted At</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupedSubmissions[$assignmentId] as $index => $model): ?>
            <tr>
                <td><?= $index + 1 ?></td> <!-- Display row index -->

                <td>
                    <?php
                            // Retrieve the student's user information for display
                            $user = User::findOne($model->USER_ID);
                            echo Html::encode($user ? $user->FIRST_NAME . ' ' . $user->LAST_NAME : 'N/A');
                            ?>
                </td>

                <td><?= Html::encode($user ? $user->EMAIL : 'N/A') ?></td> <!-- Display user email -->

                <td>
                    <?php
                            // Shorten content to first 20 words for display
                            $contentWords = explode(' ', strip_tags($model->CONTENT));
                            $shortContent = implode(' ', array_slice($contentWords, 0, 20));
                            ?>
                    <?= Html::encode($shortContent) ?>
                    <?php if (count($contentWords) > 20): ?>
                    ... <a href="<?= Url::to(['submissions/view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>">Read
                        More</a>
                    <?php endif; ?>
                </td>

                <td>
                    <!-- Display the file URL as a clickable link -->
                    <a href="<?= Url::to($model->FILE_URL) ?>" target="_blank"><?= Html::encode($model->FILE_URL) ?></a>
                </td>

                <td><?= Html::encode($model->SUBMITTED_AT) ?></td> <!-- Display submission date -->

                <td>
                    <?php
                            // Check if a grade exists for this submission
                            $grade = Grades::find()->where(['SUBMISSION_ID' => $model->SUBMISSION_ID])->one();
                            if ($grade) {
                                // Display grade with styling, and provide an edit link for admin/instructor
                                echo Html::tag('span', Html::encode($grade->GRADE), ['style' => 'color: darkblue; font-weight: bold;']);
                                if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')) {
                                    echo Html::a('Edit Grade', ['grades/update', 'GRADE_ID' => $grade->GRADE_ID], ['class' => 'btn btn-warning btn-sm']);
                                }
                            } else {
                                // Show "Not graded" message and provide add grade link for admin/instructor
                                echo Html::tag('span', 'Not graded', ['style' => 'color: purple; font-weight: bold; font-size: 15px;']);
                                if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')) {
                                    echo Html::a('Add Grade', ['grades/create', 'SUBMISSION_ID' => $model->SUBMISSION_ID], ['class' => 'btn btn-success btn-sm']);
                                }
                            }
                            ?>
                </td>

                <td>
                    <!-- Actions for admin/instructor to view, update, or delete submissions -->
                    <div class="d-flex">
                        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
                        <a href="<?= Url::to(['submissions/view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-info btn-sm">View</a>
                        <a href="<?= Url::to(['submissions/update', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-primary btn-sm">Update</a>
                        <?= Html::a('Delete', ['submissions/delete', 'SUBMISSION_ID' => $model->SUBMISSION_ID], [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data' => ['confirm' => 'Are you sure you want to delete this submission?', 'method' => 'post'],
                                    ]) ?>
                        <?php elseif (Yii::$app->user->can('student')): ?>
                        <a href="<?= Url::to(['submissions/view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-info btn-sm">View</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <!-- End of conditional table display -->
</div>