<?php
use yii\helpers\Html;
use yii\widgets\ListView;
?>

<div class="quiz-list">
    <h2>Available Quizzes</h2>

    <ul class="navbar-nav">
        <?php foreach ($quizzes as $quiz): ?>
        <li class="nav-item">
            <a class="nav-link collapsed"
                href="<?= Yii::$app->urlManager->createUrl(['/quizzes/view', 'id' => $quiz->ID]) ?>">
                <i class="bi bi-book"></i>
                <span><?= Html::encode($quiz->NAME) ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>