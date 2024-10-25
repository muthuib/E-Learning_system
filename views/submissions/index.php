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

    <!-- Check if the user is an instructor or admin to assign create privillage-->
    <div class="text-end mb-3">
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <?= Html::a('Add Submission', ['submissions/create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'ASSIGNMENT_ID',
                'label' => 'Assignment Title',
                'value' => function ($model) {
                    return $model->aSSIGNMENT? $model->aSSIGNMENT->TITLE : 'N/A';
                }
            ],
            'USER_ID',
            'CONTENT',
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