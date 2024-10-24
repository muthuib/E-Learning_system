<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Courses $model */

$this->title = 'Create Courses';
?>
<div class="courses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>