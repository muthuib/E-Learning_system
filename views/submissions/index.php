<?php

use app\models\Grades;
use app\models\User;
use app\models\Courses; // Make sure to include Courses model
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int|null $assignmentId */
/** @var int|null $courseId */

$this->title = 'Submissions';
?>
<div class="submissions-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <!-- Display message if no course is selected -->
    <?php if (empty($courseId)): ?>
        <p style="color: brown; font-weight: bold;">
            Please click a course button to see submissions.
        </p>
    <?php endif; ?>

    <!-- Course Selection Button for Admin/Instructor/Student -->
    <?php
    if (Yii::$app->user->can('admin')) {
        // Fetch all courses for admin
        $courses = Courses::find()->all();
    } elseif (Yii::$app->user->can('instructor')) {
        // Fetch only assigned courses for instructor
        $userId = Yii::$app->user->id;
        $courses = Courses::find()->where(['INSTRUCTOR_ID' => $userId])->all();
    } elseif (Yii::$app->user->can('student')) {
        // Fetch only enrolled courses for student
        $userId = Yii::$app->user->id;
        $courses = Courses::find()
            ->innerJoin('enrollments', 'enrollments.COURSE_ID = courses.COURSE_ID')
            ->where(['enrollments.USER_ID' => $userId])
            ->all();
    }

    foreach ($courses as $course) {
        echo Html::a(
            $course->COURSE_NAME, 
            ['submissions/index', 'courseId' => $course->COURSE_ID], 
            ['class' => 'btn btn-info btn-md mr-2', 'style' => 'margin-right: 10px;padding: 10px 20px; text-decoration: none; border-radius: 5px;']
        );
    }
    ?>

    <!-- Group submissions by assignment -->
    <?php if (!empty($courseId)): ?>
        <?php
        $submissions = $dataProvider->getModels();
        $groupedSubmissions = [];

        // Group each submission by its assignment ID
        foreach ($submissions as $submission) {
            $submissionAssignmentId = $submission->ASSIGNMENT_ID;
            $groupedSubmissions[$submissionAssignmentId][] = $submission;
        }

        // Check if there are no assignments for this course
        if (empty($groupedSubmissions)) {
            echo "<p style='color: brown; font-weight: bold;'>No assignment submission found for this course.</p>";
        }
        ?>

        <!-- Loop through each assignment and create a clickable link to view its submissions -->
        <?php foreach ($groupedSubmissions as $submissionAssignmentId => $assignmentSubmissions): ?>
            <h3>
                <?= Html::a(
                    Html::encode($assignmentSubmissions[0]->aSSIGNMENT->TITLE), // Assignment title
                    ['index', 'assignmentId' => $submissionAssignmentId, 'courseId' => $courseId] // Link to filter submissions by assignmentId and courseId
                ) ?>
            </h3>
        <?php endforeach; ?>

        <!-- Check if there are no submissions for the selected assignment -->
        <?php if (isset($groupedSubmissions[$assignmentId]) && empty($groupedSubmissions[$assignmentId])): ?>
            <p style="color: brown; font-weight: bold;">There are no submissions for this assignment.</p>
        <?php endif; ?>

        <!-- Display the table of submissions if an assignment has been selected by the user -->
        <?php if ($assignmentId !== null && isset($groupedSubmissions[$assignmentId])): ?>
            <table class="table table-bordered">
                <!-- Show the total number of submissions for this assignment -->
                <p style="color: brown;"><strong>Total Submissions: <?= count($groupedSubmissions[$assignmentId]) ?></strong></p>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>User Email</th>
                        <th>Content</th>
                        <th>File URL</th>
                        <th>Submitted At</th>
                        <th>Grade</th>
                        <th>Out of</th>
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
                                    ... <a href="<?= Url::to(['submissions/view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>">Read More</a>
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
                           <td style="font-weight: bold; color: black;"><?= Html::encode($model->aSSIGNMENT->TOTAL_MARKS) ?></td>


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
    <?php endif; ?>
</div>
