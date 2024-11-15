<?php

use yii\helpers\Html;
use app\models\Answers;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Quizzes $quiz */
/** @var app\models\Questions[] $questions */

\yii\web\YiiAsset::register($this);
?>

<h2><?= Html::encode($quiz->NAME) ?></h2>
<p>Duration: <?= Html::encode($quiz->DURATION) ?> seconds</p>

<div id="quiz-timer">
    <p>Time left: <span id="timer"><?= $quiz->DURATION ?></span> seconds</p>
</div>

<!-- Only display the start button if there are questions -->
<?php if (empty($questions)): ?>
<p style="color: red;">No questions for this quiz. Please contact Your instructor.</p>
<?php else: ?>
<button id=" start-quiz" onclick="startQuiz()">Start Quiz</button>
<?php endif; ?>

<!-- Questions will be displayed here if available -->
<div id="questions">
    <?php foreach ($questions as $question): ?>
    <div class="question">
        <p><?= Html::encode($question->CONTENT) ?></p>
        <?php $answers = Answers::find()->where(['QUESTION_ID' => $question->ID])->all(); ?>
        <?php foreach ($answers as $answer): ?>
        <label>
            <input type="radio" name="question-<?= $question->ID ?>" value="<?= $answer->ID ?>">
            <?= Html::encode($answer->CONTENT) ?>
        </label>
        <br>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>

<script>
let timer;
let timeLeft = <?= $quiz->DURATION ?>; // Set the timer duration

function startQuiz() {
    // Disable the start button after starting the quiz
    document.getElementById('start-quiz').disabled = true;

    // Start the timer
    timer = setInterval(function() {
        timeLeft--;
        document.getElementById('timer').textContent = timeLeft;

        // If time is up, stop the timer and alert the user
        if (timeLeft <= 0) {
            clearInterval(timer);
            alert('Time is up!');
            // Optionally, submit the quiz here by making an AJAX request to submit the answers
        }
    }, 1000); // Update every second
}
</script>