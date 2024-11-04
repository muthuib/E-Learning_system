<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Students Per Course';
?>
<div class="students-per-course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // Calculate the total number of students enrolled across all courses
    $totalStudents = 0;
    foreach ($dataProvider->getModels() as $course) {
        $totalStudents += count($course->enrollments); // Count students per course and add to total
    }
    ?>

    <h4>Total Number of Students Enrolled Across All Courses: <?= Html::encode($totalStudents) ?></h4>
    <p style="color:red;">Click on the buttons to see the list of enrolled students.</p>

    <?php foreach ($dataProvider->getModels() as $index => $course): ?>
    <?php
        // Count the number of students enrolled in this specific course
        $enrolledCount = count($course->enrollments);
        ?>

    <div class="course-section">
        <!-- Button to display the course name and the number of students enrolled. -->
        <button class="btn btn-info toggle-students" data-target="#students-<?= $index ?>">
            <?= Html::encode($course->COURSE_NAME) ?>
            <span style="font-size: 1.0em; color: purple; font-weight: bold;">(Enrolled:
                <?= $enrolledCount ?>)</span>
        </button>
        <p></p>
        <!-- Section to display enrolled students in a table, initially hidden -->
        <div id="students-<?= $index ?>" class="students-list" style="display: none;">
            <?php if ($enrolledCount > 0): ?>
            <!-- Course description -->
            <p><?= Html::encode($course->DESCRIPTION) ?></p>
            <!-- Table to display enrolled students in a structured format -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student Email</th>
                        <th>Phone Number</th>
                        <th>Enrolled At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            $studentNumber = 1; // Initialize a counter for numbering students
                            foreach ($course->enrollments as $enrollment): ?>
                    <tr>
                        <td><?= $studentNumber ?></td>
                        <td><?= Html::encode($enrollment->uSER->FIRST_NAME . '.' . $enrollment->uSER->LAST_NAME) ?></td>
                        <td><?= Html::encode($enrollment->uSER->EMAIL) ?></td>
                        <td><?= Html::encode($enrollment->uSER->PHONE_NUMBER) ?></td>
                        <td><?= Html::encode($enrollment->ENROLLED_AT) ?></td>
                    </tr>
                    <?php
                                $studentNumber++; // Increment student counter
                            endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <!-- Display message if no students are enrolled in the course -->
            <p>No students enrolled in this course.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<?php
// JavaScript to handle the show/hide functionality of the students' list
$js = <<<JS
    // Add click event to all elements with class 'toggle-students'
    $('.toggle-students').on('click', function() {
        var target = $(this).data('target'); // Get the target element to toggle

        // Hide all student lists
        $('.students-list').not(target).hide();

        // Toggle the visibility of the target element
        $(target).toggle();
    });
JS;
$this->registerJs($js, View::POS_READY);
?>