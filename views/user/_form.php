<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

//LOGIC TO IMPLEMENT BACK BUTTON TO RETURN TO RESPECTIVE TABLE OF RECORDS AS PER USER ROLE
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
//END OF LOGIC

// Fetch roles from RBAC authManager
$roles = Yii::$app->authManager->getRoles();
$roleOptions = ArrayHelper::map($roles, 'name', function ($role) {
    return ucfirst($role->name); // Capitalize each role name for display
});

// Fetch the user's current roles
$currentRoles = Yii::$app->authManager->getRolesByUser($model->ID);
$currentRoleName = array_key_first($currentRoles); // Assuming the user has one role

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'FIRST_NAME')->textInput() ?>
    <?= $form->field($model, 'LAST_NAME')->textInput() ?>
    <?= $form->field($model, 'PASSWORD')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'PHONE_NUMBER')->textInput() ?>
    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <!-- Dropdown for selecting status -->
    <?= $form->field($model, 'STATUS')->dropDownList(User::getStatusOptions(), [
        'prompt' => 'Select Status',
        'required' => true, // Makes the field required
    ]) ?>

    <!-- Dropdown for selecting role from RBAC roles -->
    <?= $form->field($model, 'USER_ROLE')->dropDownList($roleOptions, [
        'prompt' => 'Select Role',
        'options' => [$currentRoleName => ['Selected' => true]], // Pre-select the current role if updating
        'required' => true, // Makes the field required
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Add User' : 'Update User',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <!-- Back button -->
        <?= Html::a('Back', ['manage'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <div class="text-end mb-3">
        <!-- Back button -->
        <?= Html::a('Back', ['manage', 'role' => $roleToPass], ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>