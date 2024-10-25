<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "submissions".
 *
 * @property int $SUBMISSION_ID
 * @property int|null $ASSIGNMENT_ID
 * @property int|null $USER_ID
 * @property string|null $FILE_URL
 * @property string $SUBMITTED_AT
 *
 * @property Assignments $aSSIGNMENT
 * @property Grades[] $grades
 * @property User $uSER
 */
class Submissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ASSIGNMENT_ID', 'USER_ID'], 'integer'],
            [['SUBMITTED_AT'], 'safe'],
            [['FILE_URL'], 'string', 'max' => 255],
             [['CONTENT'], 'string'],
            [['ASSIGNMENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Assignments::class, 'targetAttribute' => ['ASSIGNMENT_ID' => 'ASSIGNMENT_ID']],
            [['USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['USER_ID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SUBMISSION_ID' => 'Submission ID',
            'ASSIGNMENT_ID' => 'Assignment ID',
            'USER_ID' => 'User ID',
            'FILE_URL' => 'File Url',
            'CONTENT' => 'Text Answer',
            'SUBMITTED_AT' => 'Submitted At',
        ];
    }

    /**
     * Gets query for [[ASSIGNMENT]].
     *relation to Assignments so that you can access assignment data easily.
     * @return \yii\db\ActiveQuery
     */
    public function getASSIGNMENT()
    {
        return $this->hasOne(Assignments::class, ['ASSIGNMENT_ID' => 'ASSIGNMENT_ID']);
    }

    /**
     * Gets query for [[Grades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrades()
    {
        return $this->hasMany(Grades::class, ['SUBMISSION_ID' => 'SUBMISSION_ID']);
    }

    /**
     * Gets query for [[USER]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUSER()
    {
        return $this->hasOne(User::class, ['ID' => 'USER_ID']);
    }
}