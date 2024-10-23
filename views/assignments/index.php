<?php

use app\models\Assignments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AssignmentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignments-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Assignments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ASSIGNMENT_ID',
            'COURSE_ID',
            'TITLE',
            'DESCRIPTION:ntext',
            'DUE_DATE',
            //'CREATED_AT',
            //'UPDATED_AT',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Assignments $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID]);
                 }
            ],
        ],
    ]); ?>


</div>
