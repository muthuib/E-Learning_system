<?php

use app\models\CourseCategories;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\CourseCategoriesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Course Categories';
?>
<div class="course-categories-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Course Categories', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'COURSE_ID',
            'CATEGORY_ID',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CourseCategories $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'COURSE_ID' => $model->COURSE_ID, 'CATEGORY_ID' => $model->CATEGORY_ID]);
                 }
            ],
        ],
    ]); ?>


</div>