<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Enrollments $model */

\yii\web\YiiAsset::register($this);
?>
<div class="enrollments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('admin')): ?>
        <?= Html::a('Update', ['update', 'ENROLLMENT_ID' => $model->ENROLLMENT_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ENROLLMENT_ID' => $model->ENROLLMENT_ID], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        <?= Html::a('Back', ['enrollments/index'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'USER_ID',
                'label' => 'User Email',
                'value' => function ($model) {
                    return $model->uSER->EMAIL; // Assuming you have a relation in Enrollments model named 'user'
                }
            ],
            [
                'attribute' => 'COURSE_ID',
                'label' => 'Course Name',
                'value' => function ($model) {
                    return $model->cOURSE->COURSE_NAME; // Assuming you have a relation in Enrollments model named 'course'
                }
            ],
            'ENROLLED_AT',
        ],
    ]) ?>

</div>