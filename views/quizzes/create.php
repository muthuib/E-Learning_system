<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quizzes $model */

$this->title = 'Create Quizzes';

?>
<div class="text-end">
    <p>
        <!-- Back button -->
        <?= Html::a('Back to Quizes', ['quizzes/index'], ['class' => 'btn btn-secondary']) ?>
    </p>
</div>
<div class="quizzes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>