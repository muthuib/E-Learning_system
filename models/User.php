<?php

namespace app\models;


use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Enrollment;


/**
 * This is the model class for table "users".
 *
 * @property int $ID
 * @property string $PASSWORD
 * @property string $EMAIL
 * @property string|null $AUTH_KEY
 * @property string|null $ACCESS_TOKEN
 * @property string|null $PASSWORD_RESET_TOKEN
 * @property int|null $STATUS
 * @property int|null $CREATED_AT
 * @property int|null $UPDATED_AT
 * @property string|null $VERIFICATION_TOKEN
 *
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;

    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        parent::behaviors();
        return array([
            'class' => TimestampBehavior::class,
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['CREATED_AT', 'UPDATED_AT'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['UPDATED_AT'],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FIRST_NAME', 'LAST_NAME', 'PHONE_NUMBER'], 'required'],
            [['EMAIL', 'PASSWORD'], 'required'],
            [['STATUS', 'CREATED_AT', 'UPDATED_AT'], 'integer'],
            [['PASSWORD', 'EMAIL', 'AUTH_KEY', 'ACCESS_TOKEN', 'PASSWORD_RESET_TOKEN', 'VERIFICATION_TOKEN'], 'string', 'max' => 100],
            [['EMAIL', 'PHONE_NUMBER'], 'unique', 'message' => '{attribute} already exists.'], // Unique check
            ['STATUS', 'default', 'value' => self::STATUS_INACTIVE],
            ['STATUS', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            // Ensure USER_ROLE is required and only accepts values from RBAC roles
            // ['USER_ROLE', 'required'],
            // ['USER_ROLE', 'in', 'range' => array_keys(Yii::$app->authManager->getRoles())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PASSWORD' => 'Password',
            'EMAIL' => 'Email',
            'AUTH_KEY' => 'Auth Key',
            'ACCESS_TOKEN' => 'Access Token',
            'PASSWORD_RESET_TOKEN' => 'Password Reset Token',
            'STATUS' => 'Status',
            'CREATED_AT' => 'Created At',
            'UPDATED_AT' => 'Updated At',
            'VERIFICATION_TOKEN' => 'Verification Token',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['ID' => $id, 'STATUS' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */

    public static function findByEmail($email)
    {
        return static::findOne(['EMAIL' => $email, 'STATUS' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'PASSWORD_RESET_TOKEN' => $token,
            'STATUS' => self::STATUS_ACTIVE,
        ]);
    }

    public function findByVerificationToken($token)
    {
        $this->VERIFICATION_TOKEN = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->AUTH_KEY;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->PASSWORD);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $PASSWORD
     * @throws Exception
     */
    public function setPassword($PASSWORD)
    {
        return $this->PASSWORD = Yii::$app->security->generatePasswordHash($PASSWORD);
    }
    
    /**
     * Generates "Access_token
     * @throws Exception
     */
    public function generateAccessToken(): string
    {
        return $this->ACCESS_TOKEN = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey(): string
    {
        return $this->AUTH_KEY = Yii::$app->security->generateRandomString();
    }

    public function setStatus(): int
    {
        return $this->STATUS = self::STATUS_INACTIVE;
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken(): string
    {
        return $this->PASSWORD_RESET_TOKEN = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Generates new token for email verification
     * @throws Exception
     */
    public function generateEmailVerificationToken(): string
    {
        return $this->VERIFICATION_TOKEN = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        return $this->PASSWORD_RESET_TOKEN = null;
    }

//relation method to define the relationship with the auth_assignment table:
//you need to create model AuthAssignments
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'ID']);
    }
    
    // implements the method to retrieve the roles assigned to that user through RBAC (Role-Based Access Control).
    public function getRoles()
    {
        $auth = Yii::$app->authManager;
        return $auth->getRolesByUser($this->ID); // Assuming 'ID' is the primary key in the user table
    }
    public function getRole()
    {
        // Get the role of the user from the auth_assignment table
        $authAssignment = Yii::$app->authManager->getAssignments($this->ID);
        return $authAssignment ? key($authAssignment) : null;  // Return the role name (key)
    }
 /**
     * Get the enrollments for the user (students).
     */
    public function getEnrollments()
    {
        return $this->hasMany(Enrollments::class, ['USER_ID' => 'ID']);
    }
}