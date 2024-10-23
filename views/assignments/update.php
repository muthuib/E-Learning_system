<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Assignments $model */

$this->title = 'Update Assignments: ' . $model->TITLE;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TITLE, 'url' => ['view', 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assignments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
