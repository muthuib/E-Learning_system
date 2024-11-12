<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Lessons $model */

$this->title = $model->TITLE;

\yii\web\YiiAsset::register($this);
?>
<div class="lessons-view">
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back to Lessons', ['courses/continue-classes', 'courseId' => $model->COURSE_ID], ['class' => 'btn btn-primary']) ?>

    </div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="text-end mb-3">
        <a href="<?= Url::to(['assignments/index', 'LESSON_ID' => $model->LESSON_ID]) ?>"
            class="btn btn-info">Assigments</a>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <a href="<?= Url::to(['update', 'LESSON_ID' => $model->LESSON_ID]) ?>" class="btn btn-primary">Update</a>
        <?= Html::a('Delete', ['delete', 'LESSON_ID' => $model->LESSON_ID], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this lesson?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php elseif (Yii::$app->user->can('student')): ?>

        <?php endif; ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'COURSE_ID',
                'label' => 'Course Name',
                'value' => function ($model) {
                    return $model->cOURSE->COURSE_NAME; // Assuming you have a relation in Enrollments model named 'course'
                }
            ],
            'TITLE',
            'CONTENT:ntext',
            'VIDEO_URL:url',

        ],
    ]) ?>

</div>