<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->FIRST_NAME . ' ' . $model->LAST_NAME;
\yii\web\YiiAsset::register($this);

// Get the user's roles
$roles = Yii::$app->authManager->getRolesByUser($model->ID);
$currentRole = array_map(function ($role) {
    return ucfirst($role->name); // Ensure each role name is capitalized
}, $roles);
$currentRole = implode(', ', $currentRole); // Join roles into a string for display

// Optionally, if you want to pass only the first role for simplicity
$currentRoleArray = array_values($roles); // Get the roles as an array
$roleToPass = !empty($currentRoleArray) ? $currentRoleArray[0]->name : null; // Pass only the first role

?>

<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back', ['manage', 'role' => $roleToPass], ['class' => 'btn btn-primary']) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // Concatenated Name Column
            [
                'label' => 'Name', // Label for the column
                'value' => function ($model) {
                    return Html::encode($model->FIRST_NAME . ' ' . $model->LAST_NAME);
                },
            ],
            'EMAIL:email',
            'PHONE_NUMBER',
            [
                'label' => 'Roles',
                'value' => function () use ($currentRole) {
                    return $currentRole; // Display the user's roles
                },
            ],
        ],
    ]) ?>

</div>