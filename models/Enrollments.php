<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enrollments".
 *
 * @property int $ENROLLMENT_ID
 * @property int|null $USER_ID
 * @property int|null $COURSE_ID
 * @property string $ENROLLED_AT
 *
 * @property Courses $cOURSE
 * @property User $uSER
 */
class Enrollments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enrollments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['USER_ID', 'COURSE_ID'], 'integer'],
            [['ENROLLED_AT'], 'safe'],
            [['COURSE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::class, 'targetAttribute' => ['COURSE_ID' => 'COURSE_ID']],
            [['USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['USER_ID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ENROLLMENT_ID' => 'Enrollment ID',
            'USER_ID' => 'User ID',
            'COURSE_ID' => 'Course Name',
            'ENROLLED_AT' => 'Enrolled At',
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
     * Gets query for [[USER]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUSER()
    {
        return $this->hasOne(User::class, ['ID' => 'USER_ID']);
    }
}