<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Answers $model */

$this->title = 'Create Answers';
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
