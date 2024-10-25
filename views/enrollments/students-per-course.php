<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Students Per Course';
?>
<div class="students-per-course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // Calculate total number of students across all courses
    $totalStudents = 0;
    foreach ($dataProvider->getModels() as $course) {
        $totalStudents += count($course->enrollments);
    }
    ?>

    <h4>Total Number of Students Enrolled: <?= Html::encode($totalStudents) ?></h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Description</th>
                <th>Enrolled Students</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->getModels() as $course): ?>
            <tr>
                <td><?= Html::encode($course->COURSE_NAME) ?></td>
                <td><?= Html::encode($course->DESCRIPTION) ?></td>
                <td>
                    <?php if (!empty($course->enrollments)): ?>
                    <ul>
                        <?php
                                $studentNumber = 1; // Initialize the student counter
                                foreach ($course->enrollments as $enrollment): ?>
                        <li>
                            <?= $studentNumber . ' ' . Html::encode($enrollment->uSER->EMAIL) ?>
                            <strong>(Enrolled At: <?= Html::encode($enrollment->ENROLLED_AT) ?>)</strong>
                        </li>
                        <?php
                                    $studentNumber++; // Increment the student counter
                                endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p>No students enrolled in this course.</p>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>