<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Testimonials $model */

$this->title = 'Create Testimonials';
$this->params['breadcrumbs'][] = ['label' => 'Testimonials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonials-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
