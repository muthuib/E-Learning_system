<?php

use app\models\Courses;
use app\models\Assignments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AssignmentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int|null $courseId */

$this->title = 'Assignments';

// Custom CSS for dark blue button and course heading
$this->registerCss("
    .btn-dark-blue {
        background-color: #003366; /* Custom dark blue color */
        color: white;
    }
    .course-heading {
        color: brown;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
    }
");

?>
<div class="assignments-index">
    <!-- Privilege controls for instructor/admin to add assignments -->
    <div class="text-end mb-3">
        <?= Html::a('Back to Lessons', ['lessons/index'], ['class' => 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
            <?= Html::a('Add Assignment', ['assignments/create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Display message if no course button is selected -->
    <?php if (!$courseId): ?>
        <p style="font-weight: bold; color: #f00;">Please click a course button to view assignments.</p>
    <?php endif; ?>

    <!-- Display course buttons with assignment counts, only for assigned courses -->
    <div class="mb-4">
        <?php
        // Get current user ID
        $userId = Yii::$app->user->id;

        // Fetch courses based on user role
        if (Yii::$app->user->can('instructor')) {
            // Fetch courses the user (instructor) is assigned to
            $courses = Courses::find()->where(['INSTRUCTOR_ID' => $userId])->all();
        } elseif (Yii::$app->user->can('student')) {
            // Fetch courses the user (student) is enrolled in
            $courses = Courses::find()->joinWith('enrollments')->where(['USER_ID' => $userId])->all();
        } else {
            // For admins, show all courses
            $courses = Courses::find()->all();
        }

        // Loop through the courses and display them as buttons
        foreach ($courses as $course) {
            // Count assignments in each course
            $assignmentCount = Assignments::find()->where(['COURSE_ID' => $course->COURSE_ID])->count();
            // Check if this course is selected
            $isSelected = $courseId === $course->COURSE_ID;
            echo Html::a(
                "{$course->COURSE_NAME} ({$assignmentCount})",
                ['assignments/index', 'courseId' => $course->COURSE_ID],
                [
                    'class' => 'btn ' . ($isSelected ? 'btn-dark-blue' : 'btn-secondary') . ' m-1 course-button',
                    'data-course-id' => $course->COURSE_ID,
                    'onclick' => 'return false;' // Prevents default link behavior
                ]
            );
        }
        ?>
    </div>

    <!-- Display assignments in a grid view if a course is selected -->
    <?php if ($courseId): ?>
        <?php
        $selectedCourse = Courses::findOne($courseId);
        if ($selectedCourse) {
            echo "<h2 class='course-heading'>Assignments for " . Html::encode($selectedCourse->COURSE_NAME) . "</h2>";
        }
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'COURSE_ID',
                    'label' => 'Course Name',
                    'value' => function ($model) {
                        return $model->cOURSE ? $model->cOURSE->COURSE_NAME : 'N/A';
                    },
                ],
                'TITLE',
                'DESCRIPTION:ntext',
                'DUE_DATE',
                'TOTAL_MARKS',
               [
                'class' => ActionColumn::className(),
                'template' => '{view}' . 
                            (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor') ? ' {update} {delete}' : '') . 
                            (Yii::$app->user->can('student') ? ' {submitOrSubmitted}' : ''),
                'buttons' => [
                    'submitOrSubmitted' => function ($url, $model) {
                        if ($model->isSubmitted()) {
                            return Html::button('Submitted', ['class' => 'btn btn-success btn-sm', 'disabled' => true]);
                        } else {
                            return Html::a('Submit', ['submissions/submit', 'id' => $model->ASSIGNMENT_ID], ['class' => 'btn btn-primary btn-sm']);
                        }
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($model instanceof \app\models\Assignments) {
                        return Url::toRoute([$action, 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID]);
                    }
                    return null;
                },
            ],
            ],
        ]); ?>
    <?php endif; ?>
</div>

<?php
// JavaScript to handle the course button click toggle behavior
$script = <<< JS
    $(document).on('click', '.course-button', function() {
        var courseId = $(this).data('course-id');
        
        // Toggle dark blue class on selected button and reset others
        $('.course-button').removeClass('btn-dark-blue').addClass('btn-secondary');
        $(this).removeClass('btn-secondary').addClass('btn-dark-blue');
        
        // Triggering the link to load assignments for the clicked course
        window.location.href = '/assignments/index?courseId=' + courseId;
    });
JS;
$this->registerJs($script);
?>
