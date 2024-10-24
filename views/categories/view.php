<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Categories $model */


\yii\web\YiiAsset::register($this);
?>
<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'CATEGORY_ID' => $model->CATEGORY_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'CATEGORY_ID' => $model->CATEGORY_ID], [
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
            'CATEGORY_ID',
            'CATEGORY_NAME',
        ],
    ]) ?>

</div>