<?php

use yii\helpers\Html;
use app\models\Answers;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Quizzes $quiz */
/** @var app\models\Questions[] $questions */

\yii\web\YiiAsset::register($this);
?>

<!-- Modal for Time is up -->
<div id="time-up-modal" class="modal">
    <div class="modal-content">
        <h2>Time's up!</h2>
        <p>Your time has expired, and the quiz has been submitted automatically.</p>
        <button onclick="closeModalAndSubmit()">OK</button>
    </div>
</div>

<!-- Modal for Quiz Submitted -->
<div id="quiz-submitted-modal" class="modal">
    <div class="modal-content">
        <h2>Quiz Submitted!</h2>
        <p>Your quiz has been successfully submitted.</p>
        <button onclick="closeModalAndRedirect()">OK</button>
    </div>
</div>

<!-- Display quiz title and duration -->
<h2><?= Html::encode($quiz->NAME) ?></h2>
<p>Duration: <?= $quiz->DURATION ?> seconds</p>

<!-- Timer section, initially hidden until the quiz starts -->
<div id="quiz-timer" style="display: none;">
    <p>Time left: <span id="timer"><?= $quiz->DURATION ?></span> seconds</p>
</div>

<!-- Start Quiz button to begin the quiz and timer -->
<button id="start-quiz" onclick="startQuiz()">Start Quiz</button>

<!-- Start form to submit quiz answers -->
<?php $form = ActiveForm::begin([
    'action' => ['submit-quiz', 'id' => $quiz->ID], // Ensure it posts to the correct controller action
    'method' => 'post',
    'options' => ['id' => 'quiz-form', 'data-pjax' => true]
]); ?>

<div id="questions" style="display: none;">
    <?php if (empty($questions)): ?>
    <p>No questions for this quiz.</p>
    <?php else: ?>
    <?php $counter = 1; ?>
    <?php foreach ($questions as $question): ?>
    <div class="question">
        <p style="color: black;">Question <?= $counter ?>: <?= Html::encode($question->CONTENT) ?></p>

        <?php $answers = Answers::find()->where(['QUESTION_ID' => $question->ID])->all(); ?>

        <?php if ($question->ANSWER_TYPE == 'radio'): ?>
        <?php foreach ($answers as $answer): ?>
        <label>
            <input type="radio" name="question-<?= $question->ID ?>" value="<?= $answer->ID ?>">
            <?= Html::encode($answer->CONTENT) ?>
        </label><br>
        <?php endforeach; ?>

        <?php elseif ($question->ANSWER_TYPE == 'checkbox'): ?>
        <?php foreach ($answers as $answer): ?>
        <label>
            <input type="checkbox" name="question-<?= $question->ID ?>[]" value="<?= $answer->ID ?>">
            <?= Html::encode($answer->CONTENT) ?>
        </label><br>
        <?php endforeach; ?>

        <?php elseif ($question->ANSWER_TYPE == 'text'): ?>
        <label>
            <textarea name="question-<?= $question->ID ?>" rows="3" placeholder="Type your answer here"
                style="width: 1000px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
        </label>

        <?php endif; ?>
    </div>
    <hr>
    <?php $counter++; ?>
    <?php endforeach; ?>

    <!-- Submit button to submit the quiz -->
    <button id="submit-quiz" type="submit">Submit Quiz</button>
    <?php endif; ?>
</div>

<?php ActiveForm::end(); ?>

<script>
// Initialize timer variables
let timer;
let timeLeft = <?= $quiz->DURATION ?>; // Set initial timer duration from quiz model

// Function to start the quiz and timer
function startQuiz() {
    // Hide the Start Quiz button and show the timer, questions, and Submit button
    document.getElementById('start-quiz').style.display = 'none';
    document.getElementById('quiz-timer').style.display = 'block';
    document.getElementById('questions').style.display = 'block';

    // Start countdown timer
    timer = setInterval(function() {
        timeLeft--; // Decrease time by 1 second
        document.getElementById('timer').textContent = timeLeft; // Update displayed time

        // Check if time has run out
        if (timeLeft <= 0) {
            clearInterval(timer); // Stop the timer
            showModal('time-up-modal'); // Show the "Time's up!" modal
        }
    }, 1000); // Run every second
}

// Function to show modal
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'flex'; // Show the modal by changing display to flex
}

// Function to close the "Time's up!" modal and submit the quiz
function closeModalAndSubmit() {
    closeModal('time-up-modal'); // Close the "Time's up!" modal
    submitQuiz(); // Automatically submit the form
}

// Function to close modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none'; // Hide the modal when user clicks OK
}

// Function to submit the quiz via AJAX
function submitQuiz() {
    clearInterval(timer); // Stop the timer if it's still running
    // Show the "Quiz Submitted!" modal
    showModal('quiz-submitted-modal');

    // AJAX form submission
    var form = document.getElementById('quiz-form');
    var formData = new FormData(form);

    fetch('<?= Url::to(['submit-quiz', 'id' => $quiz->ID]) ?>', {
        method: 'POST',
        body: formData
    }).then(response => response.json()).then(data => {
        if (data.status === 'success') {
            // Handle success if needed
            console.log('Quiz Submitted');
        } else {
            // Handle failure
            alert('There was an error submitting your quiz');
        }
    }).catch(error => {
        console.error('Error:', error);
    });
}

// Function to close the "Quiz Submitted!" modal and redirect to quizsubmitted view
function closeModalAndRedirect() {
    closeModal('quiz-submitted-modal'); // Close the "Quiz Submitted!" modal
    // Redirect to the quizsubmitted view
    window.location.href = '<?= \yii\helpers\Url::to(['quizzes/quizsubmitted', 'id' => $quiz->ID]) ?>';
}
</script>

<style>
/* Basic styling for modal popups */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    width: 300px;
    text-align: center;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #45a049;
}
</style>