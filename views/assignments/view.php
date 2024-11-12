<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Assignments $model */

\yii\web\YiiAsset::register($this);
?>
<div class="assignments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><div class="text-end mb-3">
         <?= Html::a('Back to Assignments', ['assignments/index'], ['class' => 'btn btn-primary']) ?>
</div>
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <?= Html::a('Update', ['update', 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'COURSE_ID',
                'label' => 'Course Name',
                'value' => function ($model) {
                    return $model->cOURSE ? $model->cOURSE->COURSE_NAME : 'N/A'; // Display course name or N/A if not found
                },
            ],
            'TITLE',
            'DESCRIPTION:ntext',
            'DUE_DATE',
            'CREATED_AT',
            'UPDATED_AT',
        ],
    ]) ?>

</div>