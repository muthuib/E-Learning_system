<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\helpers\EmailHelper;  // Import the EmailHelper class

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'email'],
        ];
    }

    public function sendEmail()
{
    $user = User::findOne(['EMAIL' => $this->email]);
    if (!$user) {
        Yii::$app->session->setFlash('error', 'No user with this email address found.');
        return false;
    }

    if ($user->STATUS !== User::STATUS_ACTIVE) {
        Yii::$app->session->setFlash('error', 'This email is not activated.');
        return false;
    }

    $user->generatePasswordResetToken();
    if ($user->save()) {
        // Use the helper to send the email
        return EmailHelper::sendEmail(
            $user->EMAIL, 
                $user->FIRST_NAME, 
                'Password Reset Request', 
                'Hello ' . htmlspecialchars($user->FIRST_NAME) . ',<br><br>Click the link below to reset your password:<br>' . 
                '<a href="' . Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->PASSWORD_RESET_TOKEN]) . '">Reset Password</a>'
            );
    }

    return false;
}

}