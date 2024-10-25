<?php

use app\models\Submissions;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User; // Ensure to include the User model

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Submissions';
?>
<div class="submissions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
    <div class="text-end mb-3">
        <?= Html::a('Add Submission', ['submissions/create'], ['class' => 'btn btn-primary']) ?>
    </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Assignment Title</th>
                <th>User Email</th> <!-- Column for user email -->
                <th>Content</th>
                <th>File URL</th>
                <th>Submitted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->getModels() as $index => $model): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= Html::encode($model->aSSIGNMENT->TITLE) ?></td>
                <td>
                    <?php
                        // Retrieve user email using USER_ID from the Submissions model
                        $user = User::findOne($model->USER_ID);
                        echo Html::encode($user ? $user->EMAIL : 'N/A'); // Display user email or N/A if not found
                        ?>
                </td>
                <td>
                    <?php
                        // Split content into an array of words
                        $contentWords = explode(' ', strip_tags($model->CONTENT)); // strip_tags removes any HTML tags if needed
                        $shortContent = implode(' ', array_slice($contentWords, 0, 20)); // Show first 20 words
                        ?>

                    <?= Html::encode($shortContent) ?>

                    <?php if (count($contentWords) > 20): ?>
                    ... <a href="<?= Url::to(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>">Read More</a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= Url::to($model->FILE_URL) ?>" target="_blank"><?= Html::encode($model->FILE_URL) ?></a>
                </td>
                <td><?= Html::encode($model->SUBMITTED_AT) ?></td>
                <td>
                    <div class="d-flex">
                        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
                        <a href="<?= Url::to(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-info btn-sm">View</a>
                        <a href="<?= Url::to(['update', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-primary btn-sm">Update</a>
                        <?= Html::a('Delete', ['delete', 'SUBMISSION_ID' => $model->SUBMISSION_ID], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this submission?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                        <?php elseif (Yii::$app->user->can('student')): ?>
                        <a href="<?= Url::to(['view', 'SUBMISSION_ID' => $model->SUBMISSION_ID]) ?>"
                            class="btn btn-info btn-sm">View</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>