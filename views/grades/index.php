<?php

use app\models\Grades;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\search\GradesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Grades';
?>
<div class="grades-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-end mb-3">
        <?= Html::a('Add Multiple Grades', ['grades/multi-grade-form'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update Multiple Grades', ['grades/multi-update-form'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php Pjax::begin(); ?>

    <?= Html::beginForm(['grades/delete-multiple'], 'post', ['id' => 'multiple-delete-form']); ?>
    <?= Html::beginForm(['grades/update-multiple'], 'post', ['id' => 'multi-update-form']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Automatically numbered column

            // Display student name associated with submission
            [
                'attribute' => 'SUBMISSION_ID',
                'value' => function ($model) {
                    $submission = $model->sUBMISSION;
                    if ($submission) {
                        $user = $submission->uSER;
                        return $user ? Html::encode($user->FIRST_NAME . ' ' . $user->LAST_NAME) : 'N/A';
                    }
                    return 'N/A';
                },
                'label' => 'Student Name'
            ],

            'GRADE', // Grade column

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Grades $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'GRADE_ID' => $model->GRADE_ID]);
                }
            ],

            // Checkbox column with Select All and Delete Selected in the header
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model) {
                    return ['value' => $model->GRADE_ID];
                },
                'header' => Html::checkBox('select_all', false, [
                    'class' => 'select-all',
                    'label' => 'Select All',
                ]) . ' ' . Html::submitButton('Delete Selected', [
                    'class' => 'btn btn-danger btn-sm ms-2',
                    'data-confirm' => 'Are you sure you want to delete the selected grades?',
                    'form' => 'multiple-delete-form',
                ]),
            ],
        ],
    ]); ?>

    <?= Html::endForm(); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$js = <<<JS
// Handle "Select All" functionality
$('.select-all').on('click', function () {
    var isChecked = $(this).is(':checked');
    $('input[name="selection[]"]').prop('checked', isChecked);
});
JS;
$this->registerJs(new JsExpression($js));
?>