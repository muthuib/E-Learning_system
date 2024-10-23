<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Assignments $model */

$this->title = $model->TITLE;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assignments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID], [
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
            'ASSIGNMENT_ID',
            'COURSE_ID',
            'TITLE',
            'DESCRIPTION:ntext',
            'DUE_DATE',
            'CREATED_AT',
            'UPDATED_AT',
        ],
    ]) ?>

</div>
