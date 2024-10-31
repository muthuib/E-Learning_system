<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->FIRST_NAME . ' ' . $model->LAST_NAME;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back', ['manage'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // Concatenated Name Column
            [
                'label' => 'Name', // Label for the column
                'value' => function ($model) {
                    return Html::encode($model->FIRST_NAME . ' ' . $model->LAST_NAME);
                },
            ],
            'EMAIL:email',
            'PHONE_NUMBER',
        ],
    ]) ?>

</div>