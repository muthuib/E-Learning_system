<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

?>

<h2 style="color: green; font-weight: bold; font-size: 30px;">Quiz Submitted Successfully!</h2>

<p>Your quiz has been successfully submitted. Here’s a special message for you:</p>

<div style="background-color: #f4f4f9; padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
    <h3 style="color: #4CAF50;">Wishing you all the
        best! <strong style="font-size: 30px; color: brown; font-weight: bold;">
            <?= Html::encode(Yii::$app->user->identity->FIRST_NAME . ' ' . Yii::$app->user->identity->LAST_NAME) ?>
        </strong>
    </h3>
    <p>Thank you for completing the quiz! We hope you did well.</p>
</div>

<!-- Link to redirect to quiz index page -->
<div style="margin-top: 20px;">
    <a href="<?= \yii\helpers\Url::to(['quizzes/index']) ?>" class="btn btn-primary">Back to Quizs</a>
</div>