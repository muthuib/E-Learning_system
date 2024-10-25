<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Assignments; // Include the Assignments model
use app\models\User; // Include the User model
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Submissions $model */

\yii\web\YiiAsset::register($this);
?>
<div class="submissions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex">
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <a href="<?= Url::to(['update', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
            class="btn btn-primary btn-sm">Update</a>
        <?= Html::a('Delete', ['delete', 'SUBMISSION_ID' => $model->SUBMISSION_ID], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this submission?',
                    'method' => 'post',
                ],
            ]) ?>
        <a href="<?= Url::to(['submissions/index', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
            class="btn btn-info btn-sm">BACK</a>
        <?php elseif (Yii::$app->user->can('student')): ?>
        <a href="<?= Url::to(['submissions/index', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
            class="btn btn-info btn-sm">BACK</a>
        <?php endif; ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'ASSIGNMENT_ID',
                'label' => 'Assignment Title',
                'value' => function ($model) {
                    return $model->aSSIGNMENT ? $model->aSSIGNMENT->TITLE : 'N/A'; // Display assignment title
                },
            ],
            [
                'attribute' => 'USER_ID',
                'label' => 'User Email',
                'value' => function ($model) {
                    $user = User::findOne($model->USER_ID); // Find the user by USER_ID
                    return $user ? $user->EMAIL : 'N/A'; // Display user email
                },
            ],
            'CONTENT',
            'FILE_URL:url',
            'SUBMITTED_AT',
        ],
    ]) ?>

</div>