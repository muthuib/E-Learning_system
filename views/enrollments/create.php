<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Enrollments $model */

$this->title = 'Create Enrollments';
?>
<div class="enrollments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>