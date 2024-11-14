<?php

use app\models\Courses;
use app\models\Enrollments;
use app\models\Lessons;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Courses';
?>
<div class="courses-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- Check if the user is an instructor or admin to assign create privilege -->
    <div class="text-end mb-3">
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <?= Html::a('Enroll a Course', ['enrollments/create'], ['class' => 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->can('admin')): ?>
        <?= Html::a('Add Course', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?php else: ?>
        <?= Html::a('Enroll a Course', ['enrollments/create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if ($model->IMAGE): ?>
                <!-- Display the course image -->
                <img src="<?= Url::to('@web/uploads/courses/' . $model->IMAGE) ?>" class="card-img-top"
                    alt="Course Image" style="height: 200px; object-fit: cover;">
                <?php else: ?>
                <!-- Placeholder image if no image is uploaded -->
                <img src="<?= Url::to('@web/images/default-course.png') ?>" class="card-img-top" alt="Default Image"
                    style="height: 200px; object-fit: cover;">
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($model->COURSE_NAME) ?></h5>
                    <p class="card-text"><?= Html::encode($model->DESCRIPTION) ?></p>
                    <p class="card-text">
                        <strong>Instructor:</strong>
                        <?= $model->iNSTRUCTOR ? Html::encode($model->iNSTRUCTOR->FIRST_NAME . ' ' . $model->iNSTRUCTOR->LAST_NAME) : 'N/A' ?>
                    </p>

                    <div class="d-flex justify-content-between">
                        <?php
                            // Check if the logged-in user is enrolled in the course
                            $isEnrolled = Enrollments::find()->where(['USER_ID' => Yii::$app->user->id, 'COURSE_ID' => $model->COURSE_ID])->exists();
                            // Check if the course has any lessons
                            $hasLessons = Lessons::find()->where(['COURSE_ID' => $model->COURSE_ID])->exists();
                            ?>

                        <?php if ($isEnrolled): ?>
                        <span class="btn btn-info btn-block">Enrolled</span>
                        <?php if ($hasLessons): ?>
                        <?= Html::a('Continue with Classes', ['continue-classes', 'courseId' => $model->COURSE_ID], ['class' => 'btn btn-dark btn-block']) ?>
                        <?php else: ?>
                        <span class="btn btn-secondary btn-block">No Lessons Available</span>
                        <?php endif; ?>
                        <?php else: ?>
                        <?= Html::a('Enroll', ['enrollments/create', 'COURSE_ID' => $model->COURSE_ID], ['class' => 'btn btn-success btn-block']) ?>
                        <?php endif; ?>
                    </div> <br>

                    <div class="d-flex justify-content-between">
                        <?php if (Yii::$app->user->can('admin')): ?>
                        <a href="<?= Url::to(['update', 'COURSE_ID' => $model->COURSE_ID]) ?>"
                            class="btn btn-primary">Update</a>
                        <?= Html::a('Delete', ['delete', 'COURSE_ID' => $model->COURSE_ID], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>