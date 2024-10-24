<?php

use app\models\Submissions;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SubmissionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Submissions';
?>
<div class="submissions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Submissions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SUBMISSION_ID',
            'ASSIGNMENT_ID',
            'USER_ID',
            'FILE_URL:url',
            'SUBMITTED_AT',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Submissions $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'SUBMISSION_ID' => $model->SUBMISSION_ID]);
                 }
            ],
        ],
    ]); ?>


</div>