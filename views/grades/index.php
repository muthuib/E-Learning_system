<?php

use app\models\Grades;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\GradesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Grades';
?>
<div class="grades-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Grades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'GRADE_ID',
            'SUBMISSION_ID',
            'GRADE',
            'GRADED_AT',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Grades $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'GRADE_ID' => $model->GRADE_ID]);
                 }
            ],
        ],
    ]); ?>


</div>