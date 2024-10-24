<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Submissions $model */

$this->title = 'Update Submissions: ' . $model->SUBMISSION_ID;
$this->params['breadcrumbs'][] = ['label' => 'Submissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SUBMISSION_ID, 'url' => ['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="submissions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
