<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

// Set the page title
$this->title = 'Login';

?>

<!-- Main container for the login form, centered on the page using flexbox -->
<div class="site-login d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="text-left">
        <!-- Center text alignment for headings -->

        <!-- Animated heading for the login page -->
        <h1 class="animate__animated animate__fadeInDown"><?= Html::encode($this->title) ?></h1>
        <p class="animate__animated animate__fadeIn">Please fill out the following fields to login:</p>

        <!-- Card component to hold the login form, with animation and max-width for responsive design -->
        <div class="card animate__animated animate__zoomIn" style="max-width: 400px; margin: auto;">
            <div class="card-body">

                <?php
                // Begin the login form with configuration for field templates, labels, and error styling
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}", // Standard template for form fields
                        'labelOptions' => ['class' => 'col-form-label mr-lg-3'], // Label styling
                        'inputOptions' => ['class' => 'form-control animate__animated animate__fadeInUp'], // Input styling with animation
                        'errorOptions' => ['class' => 'invalid-feedback'], // Error styling
                    ],
                ]);
                ?>

                <!-- Email input field with autofocus enabled -->
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <!-- Password input field -->
                <?= $form->field($model, 'password')->passwordInput() ?>

                <!-- Remember Me checkbox with custom template and animation -->
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"custom-control custom-checkbox animate__animated animate__fadeInUp\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>

                <div class="form-group">
                    <!-- Login button with animation and full-width styling -->
                    <?= Html::submitButton('Login', [
                        'class' => 'btn btn-primary login-btn animate__animated animate__pulse w-100',
                        'name' => 'login-button',
                    ]) ?>

                    <!-- Link for "Forgot password" with animation -->
                    <p class="animate__animated animate__fadeInUp mt-3">
                        <?= Html::a('Forgot password?', ['site/request-password-reset'], ['class' => 'forgot-password-link']) ?>
                    </p>
                </div>

                <!-- Sign-up link with animation, providing an option for new users to register -->
                <div class="animate__animated animate__fadeInUp">
                    <p>Don’t have an account? <?= Html::a('Sign up', ['site/signup']) ?></p>
                </div>

                <?php ActiveForm::end(); // End of the login form 
                ?>
            </div>
        </div>
    </div>
</div>

<?php
// Register custom CSS for the login page to style button hover and forgot-password link
$this->registerCss('
    .site-login {
        background-color: #f8f9fa; /* Light background color for better readability */
        min-height: 100vh;
    }
    .login-btn:hover {
        background-color: #0056b3;
        transition: background-color 0.3s ease; /* Smooth transition for button hover effect */
    }
    .forgot-password-link {
        color: #0056b3;
        text-decoration: none; /* Basic link styling */
    }
    .forgot-password-link:hover {
        text-decoration: underline; /* Underline on hover for better visibility */
    }
');
?>