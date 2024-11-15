<?php

use yii\helpers\Html;
use yii\helpers\Url;

// Set the page title
$this->title = 'Available Quizzes';
?>

<h1>Available Quizzes</h1>

<!-- Right-Aligned Add New Quiz Button -->
<div class="text-end">
    <p>
        <?= Html::a('Add New Quiz', ['quizzes/create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
<?php foreach ($quizzes as $quiz): ?>
<div>
    <h3><?= Html::encode($quiz->NAME) ?></h3>
    <?= Html::a('Add Questions', ['questions/create'], ['class' => 'btn btn-success']) ?>
    <a href="<?= Url::to(['quizzes/view', 'id' => $quiz->ID]) ?>">View Quiz</a>
</div>
<?php endforeach; ?>