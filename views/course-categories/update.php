<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CourseCategories $model */

$this->title = 'Update Course Categories: ' . $model->COURSE_ID;
$this->params['breadcrumbs'][] = ['label' => 'Course Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->COURSE_ID, 'url' => ['view', 'COURSE_ID' => $model->COURSE_ID, 'CATEGORY_ID' => $model->CATEGORY_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
