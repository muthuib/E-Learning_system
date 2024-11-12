<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Courses[] $courses */
/** @var array $courseLessonCounts */
/** @var int|null $selectedCourseId */

$this->title = 'Lessons';

// Register CSS for the selected button styling
$this->registerCss("
    .selected-button {
        background-color: darkblue !important;
        color: white !important;
    }
");

?>

<div class="lessons-index">
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back to Courses', ['courses/index'], ['class' => 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <?= Html::a('Add lesson', ['lessons/create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Display course buttons dynamically for assigned courses only -->
    <div class="text mb-3">
        <?php foreach ($courses as $course): ?>
        <?php
            // Check if this button corresponds to the selected course
            $isSelected = ($course->COURSE_ID == Yii::$app->request->get('courseId'));
            ?>
        <?= Html::a(
                $course->COURSE_NAME . ' ' .
                    Html::tag('span', '(' . ($courseLessonCounts[$course->COURSE_ID] ?? 0) . ' lessons)', [
                        'style' => 'color:white; font-weight: bold; font-size: 14px;'
                    ]),
                ['index', 'courseId' => $course->COURSE_ID],
                [
                    'class' => 'btn ' . ($isSelected ? 'selected-button' : 'btn-success') . ' course-button',
                ]
            ) ?>

        <?php endforeach; ?>
    </div>

    <!-- Check if there are no lessons -->
    <?php if ($dataProvider->getCount() === 0): ?>
    <p style="color:red;">Click the buttons to see the available lessons.</p>
    <?php else: ?>
    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($model->TITLE) ?></h5>
                    <p class="card-text">
                        Course: <?= Html::encode($model->cOURSE->COURSE_NAME) ?><br>
                        <?php
                                // Split content into an array of words
                                $contentWords = explode(' ', strip_tags($model->CONTENT)); // strip_tags removes any HTML tags if needed
                                $shortContent = implode(' ', array_slice($contentWords, 0, 20)); // Show first 20 words
                                ?>
                        <?= Html::encode($shortContent) ?>
                        <?php if (count($contentWords) > 20): ?>
                        ... <a href="<?= Url::to(['view', 'LESSON_ID' => $model->LESSON_ID]) ?>">Read More</a>
                        <?php endif; ?>
                    </p>

                    <?php if ($model->VIDEO_URL): ?>
                    <a href="<?= Html::encode($model->VIDEO_URL) ?>" target="_blank" class="btn btn-info">Watch
                        Video</a>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mt-3">
                        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
                        <a href="<?= Url::to(['view', 'LESSON_ID' => $model->LESSON_ID]) ?>"
                            class="btn btn-info">View</a>
                        <a href="<?= Url::to(['update', 'LESSON_ID' => $model->LESSON_ID]) ?>"
                            class="btn btn-primary">Update</a>
                        <?= Html::a('Delete', ['delete', 'LESSON_ID' => $model->LESSON_ID], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this lesson?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                        <?php elseif (Yii::$app->user->can('student')): ?>
                        <a href="<?= Url::to(['view', 'LESSON_ID' => $model->LESSON_ID]) ?>"
                            class="btn btn-info">View</a>
                        <a href="<?= Url::to(['assignments/index', 'LESSON_ID' => $model->LESSON_ID]) ?>"
                            class="btn btn-info">Assignments</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>