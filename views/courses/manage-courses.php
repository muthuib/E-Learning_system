<?php

use app\models\Courses;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\CoursesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Courses';
?>
<div class="courses-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-end">
        <p>
            <?= Html::a('Add Course', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'COURSE_NAME',
            'DESCRIPTION:ntext',
            //display instructors Email instead of id in the gridview
            [
                'attribute' => 'INSTRUCTOR_ID',
                'label' => 'INSTRUCTOR',
                'value' => function ($model) {
                    return $model->iNSTRUCTOR ? $model->iNSTRUCTOR->EMAIL : 'N/A'; // Display email or 'N/A' if not found
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Courses $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'COURSE_ID' => $model->COURSE_ID]);
                }
            ],
        ],
    ]); ?>


</div>