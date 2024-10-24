<?php

use app\models\Courses;
use app\models\Enrollments; // Import the Enrollments model
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Courses';
?>
<div class="courses-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-end mb-3">
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <?= Html::a('Enroll a Course', ['enrollments/create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add Course', ['create'], ['class' => 'btn btn-success']) ?>
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
                        <?= $model->iNSTRUCTOR ? Html::encode($model->iNSTRUCTOR->EMAIL) : 'N/A' ?>
                    </p>
                    <div class="d-flex justify-content-between">
                        <!-- Conditional display of Update and Delete buttons to only admins and instructors -->
                        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
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

                        <?php
                            // Check if the logged-in user is enrolled in the course
                            $isEnrolled = Enrollments::find()->where(['USER_ID' => Yii::$app->user->id, 'COURSE_ID' => $model->COURSE_ID])->exists();
                            ?>

                        <?php if ($isEnrolled): ?>
                        <span class='btn btn-info btn-block'>Enrolled</span> <!-- Indicate enrollment -->
                        <?= Html::a('Continue with Classes', ['lessons/index', 'COURSE_ID' => $model->COURSE_ID], ['class' => 'btn
                        btn-dark btn-block']) ?>
                        <?php else: ?>
                        <?= Html::a('Enroll', ['enrollments/create', 'COURSE_ID' => $model->COURSE_ID], ['class' => 'btn btn-success btn-block']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>