<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
/** @var array $courseResults */

$this->title = 'Student Results';

?>

<div class="results-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
                    <!-- Show name and email columns for admin/instructor -->
                    <th>Student Name</th>
                    <th>Email</th>
                <?php endif; ?>
                <th>Course Name</th>
                <th>Grade (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courseResults as $result): ?>
                <tr>
                    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
                        <!-- Show student name and email for admin/instructor -->
                        <td><?= Html::encode($result['student']->FIRST_NAME . ' ' . $result['student']->LAST_NAME) ?></td>
                        <td><?= Html::encode($result['student']->EMAIL) ?></td>
                    <?php endif; ?>
                    <!-- Show course and grade for everyone -->
                    <td><?= Html::encode($result['course']->COURSE_NAME) ?></td>
                    <td><?= Html::encode(number_format($result['averageGrade'], 2)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (Yii::$app->user->can('admin')): ?>
        <button class="btn btn-primary" id="release-results">Release Results</button>
    <?php endif; ?>
</div>

<?php
// JavaScript to handle releasing results for the admin
$releaseUrl = Url::to(['results/release']);
$this->registerJs(<<<JS
    $('#release-results').on('click', function() {
        if (confirm('Are you sure you want to release the results?')) {
            $.post('$releaseUrl', function(response) {
                if (response.success) {
                    alert('Results released successfully!');
                    location.reload();
                } else {
                    alert('Failed to release results!');
                }
            }).fail(function() {
                alert('An error occurred while releasing the results.');
            });
        }
    });
JS, View::POS_READY);
?>
