<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quizzes $model */

$this->title = 'Update Quizzes: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quizzes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
