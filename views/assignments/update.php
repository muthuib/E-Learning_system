<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Assignments $model */

$this->title = 'Update Assignments';

?>
<div class="assignments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>