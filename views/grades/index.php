<?php

use app\models\Grades;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\GradesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Grades'; // Set the title for the page
?>
<div class="grades-index">

    <h1><?= Html::encode($this->title) ?></h1> <!-- Display the title -->

    <p>
        <!-- Button to create new grades -->
        <?= Html::a('Create Grades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Serial column for numbering

            // Fetch SUBMISSION_ID details and display student name
            [
                'attribute' => 'SUBMISSION_ID',
                'value' => function ($model) {
                    // Get the submission associated with the grade
                    $submission = $model->sUBMISSION;
                    if ($submission) {
                        // Fetch the user associated with the submission
                        $user = $submission->uSER; // Assuming there's a relation in the Submission model
                        return $user ? Html::encode($user->FIRST_NAME . ' ' . $user->LAST_NAME) : 'N/A'; // Display full name
                    }
                    return 'N/A'; // Return 'N/A' if no submission found
                },
                'label' => 'Student Name' // Change the label to 'Student Name'
            ],

            'GRADE', // Grade column
            'GRADED_AT', // Graded at column

            [
                'class' => ActionColumn::className(), // Action buttons
                'urlCreator' => function ($action, Grades $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'GRADE_ID' => $model->GRADE_ID]); // Create URL for action buttons
                }
            ],
        ],
    ]); ?>

</div>