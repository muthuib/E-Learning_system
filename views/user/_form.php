<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

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
    <?php ActiveForm::end(); ?>

</div>