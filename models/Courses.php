<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "courses".
 *
 * @property int $COURSE_ID
 * @property string $COURSE_NAME
 * @property string|null $DESCRIPTION
 * @property int|null $INSTRUCTOR_ID
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 *
 * @property Assignments[] $assignments
 * @property Categories[] $cATEGORies
 * @property CourseCategories[] $courseCategories
 * @property Enrollments[] $enrollments
 * @property User $iNSTRUCTOR
 * @property Lessons[] $lessons
 */
class Courses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['COURSE_NAME'], 'required'],
            [['COURSE_NAME'], 'unique', 'message' => 'This course already exists.'], // Ensure the course name is unique
            [['DESCRIPTION'], 'string'],
            [['INSTRUCTOR_ID'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['COURSE_NAME'], 'string', 'max' => 255],
            [['INSTRUCTOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['INSTRUCTOR_ID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'COURSE_ID' => 'Course ID',
            'COURSE_NAME' => 'Course Name',
            'DESCRIPTION' => 'Description',
            'INSTRUCTOR_ID' => 'Instructor',
            'CREATED_AT' => 'Created At',
            'UPDATED_AT' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignments::class, ['COURSE_ID' => 'COURSE_ID']);
    }

    /**
     * Gets query for [[CATEGORies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCATEGORies()
    {
        return $this->hasMany(Categories::class, ['CATEGORY_ID' => 'CATEGORY_ID'])->viaTable('course_categories', ['COURSE_ID' => 'COURSE_ID']);
    }

    /**
     * Gets query for [[CourseCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseCategories()
    {
        return $this->hasMany(CourseCategories::class, ['COURSE_ID' => 'COURSE_ID']);
    }

    /**
     * Gets query for [[Enrollments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments()
    {
        return $this->hasMany(Enrollments::class, ['COURSE_ID' => 'COURSE_ID']);
    }

    /**
     * Gets query for [[INSTRUCTOR]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getINSTRUCTOR()
    {
        return $this->hasOne(User::class, ['ID' => 'INSTRUCTOR_ID']);
    }

    /**
     * Gets query for [[Lessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lessons::class, ['COURSE_ID' => 'COURSE_ID']);
    }
    
    //ensure that CREATED_AT and UPDATED_AT are set to the current timestamp when a new record is created.
    // You can do this in the beforeSave method.
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Set the CREATED_AT and UPDATED_AT fields based on the insert flag
            if ($insert) {
                // Set CREATED_AT to current timestamp
                $this->CREATED_AT = date('Y-m-d H:i:s'); // For DATETIME format
            }
            // Always update UPDATED_AT when saving
            $this->UPDATED_AT = date('Y-m-d H:i:s'); // For DATETIME format
            return true;
        }
        return false;
    }
}