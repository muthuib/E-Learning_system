<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Lessons $model */

$this->title = 'Update Lessons';
?>
<div class="lessons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>