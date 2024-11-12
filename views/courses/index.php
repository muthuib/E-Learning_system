<?php

use app\models\Courses;
use app\models\Enrollments; // Import the Enrollments model
use app\models\Lessons; // Import the Lessons model to check for lessons
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Courses';
?>
<div class="courses-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- Check if the user is an instructor or admin to assign create privillage-->
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
            <!-- Adjust the col-md-4 for the number of columns -->
            <div class="card h-100">
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

                        <?php if ($isEnrolled): ?> <span class='btn btn-info btn-block'>Enrolled</span>
                        <!-- Indicate enrollment -->

                        <?php if ($hasLessons): ?>
                        <?= Html::a('Continue with Classes', ['continue-classes', 'courseId' => $model->COURSE_ID], ['class' => 'btn btn-dark btn-block']) ?>

                        <?php else: ?>
                        <span class='btn btn-secondary btn-block'>No Lessons Available</span>
                        <?php endif; ?>
                        <?php else: ?>
                        <?= Html::a('Enroll', ['enrollments/create', 'COURSE_ID' => $model->COURSE_ID], ['class' => 'btn btn-success btn-block']) ?>
                        <?php endif; ?>
                    </div> <br>
                    <div class="d-flex justify-content-between">
                        <!-- Conditional display of Update and Delete buttons to only admins and instructors -->
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