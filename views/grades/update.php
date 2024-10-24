<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Grades $model */

$this->title = 'Update Grades: ' . $model->GRADE_ID;
$this->params['breadcrumbs'][] = ['label' => 'Grades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GRADE_ID, 'url' => ['view', 'GRADE_ID' => $model->GRADE_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="grades-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
