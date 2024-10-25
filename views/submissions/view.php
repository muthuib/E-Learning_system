<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Submissions $model */


\yii\web\YiiAsset::register($this);
?>
<div class="submissions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'SUBMISSION_ID' => $model->SUBMISSION_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'SUBMISSION_ID' => $model->SUBMISSION_ID], [
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
            'SUBMISSION_ID',
            'ASSIGNMENT_ID',
            'USER_ID',
            'CONTENT',
            'FILE_URL:url',
            'SUBMITTED_AT',
        ],
    ]) ?>

</div>