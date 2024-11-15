<?php 
namespace app\models;

use Yii;
use yii\base\Model;
use app\helpers\EmailHelper;  // Import the EmailHelper class
use yii\rbac\Role;

class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $password;
    public $password_repeat;
    public $user_role = 'student';  // Default role is 'student'

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone_number', 'password', 'password_repeat'], 'required'],
            ['email', 'email'],
            [['password', 'password_repeat'], 'string', 'min' => 4, 'max' => 100],
            ['phone_number', 'string', 'min' => 10, 'max' => 13],
            ['phone_number', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Phone number must contain only digits.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'validateEmail'],
            ['phone_number', 'validatePhoneNumber'],  // Add custom phone number validation
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
            'user_role' => 'User Role',  // Still here for display purposes, but not used for input
        ];
    }

    // Custom validation for email
    public function validateEmail($attribute, $params)
    {
        if (User::find()->where(['email' => $this->email])->exists()) {
            $this->addError($attribute, 'This email address is already registered.');
        }
    }

    // Custom validation for phone number
    public function validatePhoneNumber($attribute, $params)
    {
        if (User::find()->where(['phone_number' => $this->phone_number])->exists()) {
            $this->addError($attribute, 'This phone number is already registered.');
        }
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->FIRST_NAME = $this->first_name;
        $user->LAST_NAME = $this->last_name;
        $user->EMAIL = $this->email;
        $user->PHONE_NUMBER = $this->phone_number;
        $user->PASSWORD = Yii::$app->security->generatePasswordHash($this->password);
        $user->ACCESS_TOKEN = Yii::$app->security->generateRandomString();
        $user->AUTH_KEY = Yii::$app->security->generateRandomString();
        $user->generateEmailVerificationToken();
        $user->STATUS = 9;  // User initially inactive

        // Save the user first to get the user ID
        if ($user->save()) {
            // Assign the 'student' role using RBAC
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('student'); // Assuming 'student' role exists in RBAC

            if ($role) {
                // Assign the role to the new user
                $auth->assign($role, $user->ID); // Assign the role to the new user
            }

            // Use the EmailHelper to send the confirmation email
            $emailSent = EmailHelper::sendEmail(
                $user->EMAIL, 
                $user->FIRST_NAME, 
                'Email Verification', 
                'Hello ' . htmlspecialchars($user->FIRST_NAME) . ',<br><br>Click the link below to verify your email address:<br>' . 
                '<a href="' . Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->VERIFICATION_TOKEN]) . '">Verify Email</a>'
            );

            if ($emailSent) {
                Yii::$app->session->setFlash('success', 'Please check your email to confirm your account.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending the confirmation email.');
            }

            return Yii::$app->response->redirect(['site/index']);
        } else {
            Yii::$app->session->setFlash('error', 'There was a problem signing up. Details: ' . print_r($user->errors, true));
            Yii::error($user->errors);
        }

        return false;
    }
}