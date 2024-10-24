<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Courses $model */

\yii\web\YiiAsset::register($this);
?>
<div class="courses-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'COURSE_ID' => $model->COURSE_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'COURSE_ID' => $model->COURSE_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'COURSE_ID',
            'COURSE_NAME',
            'DESCRIPTION:ntext',
            'INSTRUCTOR_ID',
            'CREATED_AT',
            'UPDATED_AT',
        ],
    ]) ?>

</div>