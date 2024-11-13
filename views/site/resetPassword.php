<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ResetPasswordForm */
/* @var $token string */

$this->title = 'Reset Password';
?>

<div class="site-reset-password">
    <!-- Center the form within a card -->
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 style="font-size: 30px; font-weight: bold;"><?= Html::encode($this->title) ?></h1>
                    <p>Please create your new password:</p>
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Reset', ['class' => 'btn btn-primary', 'name' => 'reset-button']) ?>
                    </div>

                    <?= Html::hiddenInput('token', $token) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Register custom CSS to center the form and style the card
$this->registerCss('
        .row.justify-content-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
');
?>