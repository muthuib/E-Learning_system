<?php

use app\models\Assignments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AssignmentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Assignments';
?>
<div class="assignments-index">
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back to Lessons', ['lessons/index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Check if the user is an instructor or admin to assign create privilege-->
    <div class="text-end mb-3">
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <?= Html::a('Add Assignment', ['assignments/create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'COURSE_ID',
            'label' => 'Course Name',
            'value' => function ($model) {
                return $model->cOURSE ? $model->cOURSE->COURSE_NAME : 'N/A'; // Display course name or N/A if not found
            },
        ],
        'TITLE',
        'DESCRIPTION:ntext',
        'DUE_DATE',
        [
            'class' => ActionColumn::className(),
            'template' => '{view} {submitOrSubmitted}' . (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor') ? ' {update} {delete}' : ''),
            'buttons' => [
                'submitOrSubmitted' => function ($url, $model) {
                    // Use the new method to check if the assignment has been submitted
                    if ($model->isSubmitted()) {
                        return Html::button(
                            'Submitted',
                            ['class' => 'btn btn-success btn-sm', 'disabled' => true] // Disable the button
                        );
                    } else {
                        return Html::a(
                            'Submit',
                            ['submissions/submit', 'id' => $model->ASSIGNMENT_ID],
                            ['class' => 'btn btn-primary btn-sm']
                        );
                    }
                },
            ],
            'urlCreator' => function ($action, Assignments $model, $key, $index, $column) {
                return Url::toRoute([$action, 'ASSIGNMENT_ID' => $model->ASSIGNMENT_ID]);
            },
        ],

    ],
]); ?>

</div>