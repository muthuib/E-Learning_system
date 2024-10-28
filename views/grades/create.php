<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Grades $model */

$this->title = 'Add Grade';
?>
<div class="grades-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>