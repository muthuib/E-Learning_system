<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * classSignupForm
 * 
 * @author Benjamin Muthui <benmuthui98@gmail.com>
 * @package app\models
 */
class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone_number', 'password', 'password_repeat'], 'required'],
            [['email', 'password', 'password_repeat'], 'string', 'min' => 4, 'max' => 100],
            ['phone_number', 'string', 'min' => 10, 'max' => 13],
            ['phone_number', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Phone number must contain only digits.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password']
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
        ];
    }
    // check if the email is registered
    public function validateEmail($attribute, $params)
    {
        if (User::find()->where(['email' => $this->email])->exists()) {
            $this->addError($attribute, 'This email address is already registered.');
        }
    }
   
    public function signup()
    {
        $user = new User();
        $user->FIRST_NAME = $this->first_name;
        $user->LAST_NAME = $this->last_name;
        $user->EMAIL = $this->email;
        $user->PHONE_NUMBER = $this->phone_number;
        $user->PASSWORD = yii::$app->security->generatePasswordHash($this->password);
        $user->ACCESS_TOKEN = yii::$app->security->generateRandomString();
        $user->AUTH_KEY = yii::$app->security->generateRandomString();

        // Generate confirmation token during sign up
        $user->generateEmailVerificationToken();
        $user->status = 9;  // User initially inactive

        if ($user->save()) {
            // Send confirmation email
            if ($this->sendConfirmationEmail($user)) {
                Yii::$app->session->setFlash('success', 'Please check your email to confirm your account.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending the confirmation email.');
            }

            return Yii::$app->response->redirect(['site/index']);
        } else {
            Yii::$app->session->setFlash('error', 'There was an error during registration.');
        }

        return false; // Indicate failure if user save was unsuccessful
    }

    protected function sendConfirmationEmail($user)
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true); // Enable exceptions

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'benmuthui98@gmail.com'; // Your SMTP username
            $mail->Password = 'wzlp bfwf scgl yide'; // Your SMTP password (App Password for Gmail)
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // TCP port to connect to

            // Set email format to HTML
            $mail->setFrom('info@roundtech.com', 'Roundtech Solutions');
            $mail->addAddress($user->EMAIL, $user->FIRST_NAME); // Add a recipient

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = 'Hello ' . htmlspecialchars($user->FIRST_NAME) . ',<br><br>Click the link below to verify your email address:<br>' .
            '<a href="' . Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->VERIFICATION_TOKEN]) . '">Verify Email</a>';


                
            $mail->send();
            return true;
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            Yii::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    }