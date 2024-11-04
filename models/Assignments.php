<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "assignments".
 *
 * @property int $ASSIGNMENT_ID
 * @property int|null $COURSE_ID
 * @property string $TITLE
 * @property string|null $DESCRIPTION
 * @property string|null $DUE_DATE
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 *
 * @property Courses $cOURSE
 * @property Submissions[] $submissions
 */
class Assignments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assignments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['COURSE_ID'], 'integer'],
            [['COURSE_ID'], 'required', 'message' => 'Course Name cannot be blank.'], // Ensures COURSE_ID is mandatory
            [['TITLE'], 'required'],
            [['DESCRIPTION'], 'string'],
            [['DUE_DATE', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['TITLE'], 'string', 'max' => 255],
            [['COURSE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::class, 'targetAttribute' => ['COURSE_ID' => 'COURSE_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ASSIGNMENT_ID' => 'Assignment ID',
            'COURSE_ID' => 'Course Name',
            'TITLE' => 'Title',
            'DESCRIPTION' => 'Description',
            'DUE_DATE' => 'Due Date',
            'CREATED_AT' => 'Created At',
            'UPDATED_AT' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[COURSE]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCOURSE()
    {
        return $this->hasOne(Courses::class, ['COURSE_ID' => 'COURSE_ID']);
    }

    /**
     * Gets query for [[Submissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubmissions()
    {
        return $this->hasMany(Submissions::class, ['ASSIGNMENT_ID' => 'ASSIGNMENT_ID']);
    }
    /**
     * Check if the assignment has been submitted by the current user.
     * @return bool
     */
    public function isSubmitted()
    {
        return Submissions::find()
            ->where(['ASSIGNMENT_ID' => $this->ASSIGNMENT_ID, 'USER_ID' => Yii::$app->user->id])
            ->exists();
    }

    
}