<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Enrollments';
?>
<div class="enrollments-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-end">
        <p>
            <?= Html::a('Enroll Course', ['courses/index'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-4 mb-4">
            <!-- Adjust the col-md-4 for the number of columns per row -->
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($model->cOURSE->COURSE_NAME) ?></h5>
                    <p class="card-text">
                        <?= Html::encode($model->uSER->EMAIL) ?><br>
                        <strong>Enrolled At:</strong> <?= Html::encode($model->ENROLLED_AT) ?>
                    </p>
                    <div class="d-flex justify-content-between">
                        <!-- Action buttons -->
                        <a href="<?= Url::to(['view', 'ENROLLMENT_ID' => $model->ENROLLMENT_ID]) ?>"
                            class="btn btn-info">View</a>
                        <a href="<?= Url::to(['update', 'ENROLLMENT_ID' => $model->ENROLLMENT_ID]) ?>"
                            class="btn btn-primary">Update</a>
                        <?= Html::a('Delete', ['delete', 'ENROLLMENT_ID' => $model->ENROLLMENT_ID], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>