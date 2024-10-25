<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lessons';
?>
<div class="lessons-index">
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back to Courses', ['courses/index'], ['class' => 'btn btn-primary']) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
    <div class="text-end mb-3">
        <?= Html::a('Add Lesson', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php endif; ?>
    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-4 mb-4">
            <!-- Adjust col-md-4 for number of columns per row -->
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
                            class="btn btn-info">Assigments available</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>