<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Management';
?>
<?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
<div class="text-end mb-3">
    <?= Html::a('Add User', ['user/create'], ['class' => 'btn btn-success']) ?>
</div>
<?php endif; ?>
<h1><?= Html::encode($this->title) ?></h1>

<!-- Navigation Links for User Groups -->
<div class="mb-3">
    <?= Html::a('Students', ['user/manage', 'role' => 'student'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Instructors', ['user/manage', 'role' => 'instructor'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Admins', ['user/manage', 'role' => 'admin'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Unassigned Users', ['user/manage', 'role' => 'unassigned'], ['class' => 'btn btn-warning']) ?>
    <!-- New button -->
</div>

<!-- Grouped tables for different roles based on the role GET parameter -->
<?php if (isset($_GET['role'])): ?>
<h2><?= Html::encode(ucfirst($_GET['role'])) ?>s</h2>
<?php
    // Initialize a counter for the current group
    $currentIndex = 1;
    $totalCount = 0; // Total users counter for the current group

    foreach ($dataProvider->models as $user) {
        if ($_GET['role'] === 'unassigned') {
            if (empty(Yii::$app->authManager->getRolesByUser($user->ID))) {
                $totalCount++; // Increment count for unassigned users
            }
        } else {
            if (in_array($_GET['role'], array_keys(Yii::$app->authManager->getRolesByUser($user->ID)))) {
                $totalCount++; // Increment count for valid user
            }
        }
    }
    ?>

<!-- Display the total count of users in the selected role -->
<p>Total number of <?= Html::encode(ucfirst($_GET['role'])) ?>s: <?= $totalCount ?></p>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role Assignment</th> <!-- column for role assignment -->
            <th>Actions</th> <!-- Updated Actions header -->
        </tr>
    </thead>
    <tbody>
        <?php
            // Reset current index counter for display
            $currentIndex = 1;
            foreach ($dataProvider->models as $user): ?>
        <?php if ($_GET['role'] === 'unassigned'): ?>
        <?php if (empty(Yii::$app->authManager->getRolesByUser($user->ID))): ?>
        <tr>
            <td><?= $currentIndex++ ?></td> <!-- Use currentIndex for numbering -->
            <td><?= Html::encode($user->FIRST_NAME . ' ' . $user->LAST_NAME) ?></td>
            <td><?= Html::encode($user->EMAIL) ?></td>
            <td>
                <!-- Role Assignment -->
                <?= Html::beginForm(['user/assign-role'], 'post') ?>
                <?= Html::hiddenInput('userId', $user->ID) ?>
                <?= Html::dropDownList('roleName', null, [
                                    'admin' => 'Admin',
                                    'instructor' => 'Instructor',
                                    'student' => 'Student',
                                ], ['prompt' => 'Select Role']) ?>
                <?= Html::submitButton('Assign Role', ['class' => 'btn btn-primary']) ?>
                <?= Html::endForm() ?>
            </td>
            <td>
                <!-- View User Button -->
                <?= Html::a('View', ['user/view', 'id' => $user->ID], ['class' => 'btn btn-info btn-sm']) ?>

                <!-- Update User Button -->
                <?= Html::a('Update', ['user/update', 'id' => $user->ID], ['class' => 'btn btn-warning btn-sm']) ?>

                <!-- Delete User Button -->
                <?= Html::beginForm(['user/delete', 'id' => $user->ID], 'post', ['style' => 'display:inline;']) ?>
                <?= Html::submitButton('Delete', [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data-confirm' => 'Are you sure you want to delete this user?',
                                ]) ?>
                <?= Html::endForm() ?>
            </td>
        </tr>
        <?php endif; ?>
        <?php else: ?>
        <?php if (in_array($_GET['role'], array_keys(Yii::$app->authManager->getRolesByUser($user->ID)))): ?>
        <tr>
            <td><?= $currentIndex++ ?></td> <!-- Use currentIndex for numbering -->
            <td><?= Html::encode($user->FIRST_NAME . ' ' . $user->LAST_NAME) ?></td>
            <td><?= Html::encode($user->EMAIL) ?></td>
            <td>
                <!-- Role Assignment -->
                <?= Html::beginForm(['user/assign-role'], 'post') ?>
                <?= Html::hiddenInput('userId', $user->ID) ?>
                <?= Html::dropDownList('roleName', null, [
                                    'admin' => 'Admin',
                                    'instructor' => 'Instructor',
                                    'student' => 'Student',
                                ], ['prompt' => 'Select Role']) ?>
                <?= Html::submitButton('Assign Role', ['class' => 'btn btn-primary']) ?>
                <?= Html::endForm() ?>
            </td>
            <td>
                <!-- View User Button -->
                <?= Html::a('View', ['user/view', 'id' => $user->ID], ['class' => 'btn btn-info btn-sm']) ?>

                <!-- Update User Button -->
                <?= Html::a('Update', ['user/update', 'id' => $user->ID], ['class' => 'btn btn-warning btn-sm']) ?>

                <!-- Delete User Button -->
                <?= Html::beginForm(['user/delete', 'id' => $user->ID], 'post', ['style' => 'display:inline;']) ?>
                <?= Html::submitButton('Delete', [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data-confirm' => 'Are you sure you want to delete this user?',
                                ]) ?>
                <?= Html::endForm() ?>
            </td>
        </tr>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p style="color: red;">Please select a role to view users.</p>
<?php endif; ?>