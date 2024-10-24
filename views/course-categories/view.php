<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\CourseCategories $model */

$this->title = $model->COURSE_ID;
$this->params['breadcrumbs'][] = ['label' => 'Course Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="course-categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'COURSE_ID' => $model->COURSE_ID, 'CATEGORY_ID' => $model->CATEGORY_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'COURSE_ID' => $model->COURSE_ID, 'CATEGORY_ID' => $model->CATEGORY_ID], [
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
            'CATEGORY_ID',
        ],
    ]) ?>

</div>
