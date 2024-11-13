<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PasswordResetRequestForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Request Password Reset';
?>

<div class="site-request-password-reset">
    <!-- Center the form within a card -->
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 style="font-size: 30px; font-weight: bold;"><?= Html::encode($this->title) ?></h1>
                    <p>Please fill out your email. A link to reset the password will be sent there.</p>
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'request-button']) ?>
                    </div>

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