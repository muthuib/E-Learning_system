<?php

use app\models\Courses;
use app\models\Assignments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int|null $courseId */
/** @var int|null $assignmentId */
/** @var \yii\web\User $user */

$this->title = 'Grades';
?>

<div class="grades-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Display course buttons -->
    <div class="mb-4">
        <p style="color: brown;">Select a Course to view grades</p>
        <?php
        // Check user role
        $userRole = Yii::$app->user->identity->role;  // Get the user's role
        $userId = Yii::$app->user->identity->ID;  // Get the user ID

        // Load courses based on user role
        if ($userRole == 'admin') {
            // Admin sees all courses
            $courses = Courses::find()->all();
        } elseif ($userRole == 'instructor') {
            // Instructor sees only assigned courses
            $courses = Courses::find()->where(['INSTRUCTOR_ID' => $userId])->all();
        } elseif ($userRole == 'student') {
            // Student sees only enrolled courses (assuming enrollment model is available)
            $courses = Courses::find()
                ->joinWith('enrollments') // Assuming the relationship is set
                ->where(['enrollments.USER_ID' => $userId])
                ->all();
        }

        foreach ($courses as $course) {
            echo Html::a(
                $course->COURSE_NAME,
                ['grades/index', 'courseId' => $course->COURSE_ID],
                [
                    'class' => 'btn ' . (isset($courseId) && $courseId == $course->COURSE_ID ? 'btn-info' : 'btn-secondary') . ' m-1'
                ]
            );
        }
        ?>
    </div>

    <!-- Display assignment links if a course is selected -->
    <?php if (isset($courseId)): ?>
        <?php $selectedCourse = Courses::findOne($courseId); ?>
        <ul style="list-style-type: none;"> <!-- Remove default dots -->
            <p style="color: green;">Assignments for <?= Html::encode($selectedCourse->COURSE_NAME) ?></p>
            <?php
            $assignments = Assignments::find()->where(['COURSE_ID' => $courseId])->all();
            $counter = 1; // Initialize counter for numbering assignments
            foreach ($assignments as $assignment) {
                echo '<li class="assignment" id="assignment-' . $assignment->ASSIGNMENT_ID . '">' . $counter . '. ' . Html::a(
                    Html::encode($assignment->TITLE),
                    ['grades/index', 'courseId' => $courseId, 'assignmentId' => $assignment->ASSIGNMENT_ID],
                    ['class' => 'assignment-link']
                ) . '</li>';
                $counter++; // Increment counter after each assignment
            }
            ?>
        </ul>
    <?php endif; ?>

    <!-- Display grades if an assignment is selected -->
    <?php if (isset($assignmentId)): ?>
        <?php
        // Find assignment title for display
        $assignment = Assignments::findOne($assignmentId);
        $assignmentTitle = $assignment ? Html::encode($assignment->TITLE) : '';
        ?>
        <h style="color: purple; font-weight: bold;">Grades for Assignment: <?= $assignmentTitle ?></h>

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'SUBMISSION_ID',
                    'label' => 'Student Name',
                    'value' => function ($model) {
                        // Ensure model is an instance of Grades and handle relationships properly
                        return $model->sUBMISSION && $model->sUBMISSION->uSER
                            ? Html::encode($model->sUBMISSION->uSER->FIRST_NAME . ' ' . $model->sUBMISSION->uSER->LAST_NAME)
                            : 'N/A';
                    },
                ],
                'GRADE',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'urlCreator' => function ($action, $model, $key, $index, $column) {
                        // Ensure model is an instance of Grades for correct URL generation
                        return Url::toRoute([$action, 'GRADE_ID' => $model->GRADE_ID]);
                    },
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    <?php endif; ?>
</div>

<?php
$js = <<<JS
// Hide all assignments except the clicked one and show grades section
$('.assignment-link').on('click', function(e) {
    e.preventDefault(); // Prevent default link behavior
    var clickedAssignmentId = $(this).parent().attr('id').split('-')[1]; // Get the assignment ID
    
    // Hide all assignments
    $('.assignment').each(function() {
        if ($(this).attr('id') !== 'assignment-' + clickedAssignmentId) {
            $(this).hide();
        }
    });

    // Show the clicked assignment and the grades section
    $('#assignment-' + clickedAssignmentId).show();
    
    // Optionally, navigate to the grades page for the clicked assignment
    window.location.href = $(this).attr('href');
});
JS;
$this->registerJs(new JsExpression($js));
?>
