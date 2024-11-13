<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Signup';

?>

<!-- Center the signup form card on the page -->
<div class="site-signup d-flex justify-content-center align-items-center" style="min-height: 130vh;">
    <div class="text-left">

        <!-- Title and description text with animations -->
        <h1 class="animate__animated animate__fadeInDown"><?= Html::encode($this->title) ?></h1>
        <p class="animate__animated animate__fadeIn">Please fill out the following fields to Register:</p>

        <!-- Card with animation and responsive design constraints -->
        <div class="card animate__animated animate__zoomIn" style="max-width: 600px; width: 100%;">
            <div class="card-body">

                <?php
                // Start the signup form
                $form = ActiveForm::begin([
                    'id' => 'signup-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-form-label animate__animated animate__fadeInUp'],
                        'inputOptions' => ['class' => 'form-control animate__animated animate__fadeInUp'],
                        'errorOptions' => ['class' => 'invalid-feedback'],
                    ],
                ]);
                ?>

                <!-- Form fields for signup information -->
                <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'last_name')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'phone_number')->textInput() ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                <!-- Submit button -->
                <div class="form-group">
                    <div>
                        <?= Html::submitButton('Register', [
                            'class' => 'btn btn-primary signup-btn animate__animated animate__pulse w-100',
                            'name' => 'signup-button',
                        ]) ?>
                    </div>
                </div>
                <!-- Login link with animation, providing an option for existing users to login -->
                <div class="animate__animated animate__fadeInUp">
                    <p> Already have an account? <?= Html::a('Login', ['site/login']) ?></p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
// Custom CSS for button hover animation
$this->registerCss('
    .signup-btn:hover {
        background-color: #0056b3;
        transition: background-color 0.3s ease;
    }
');
?>