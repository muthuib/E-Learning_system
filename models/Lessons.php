<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lessons".
 *
 * @property int $LESSON_ID
 * @property int|null $COURSE_ID
 * @property string $TITLE
 * @property string|null $CONTENT
 * @property string|null $VIDEO_URL
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 *
 * @property Courses $cOURSE
 */
class Lessons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lessons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['COURSE_ID'], 'integer'],
            [['TITLE'], 'required'],
            [['CONTENT'], 'string'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['TITLE', 'VIDEO_URL'], 'string', 'max' => 255],
            [['COURSE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::class, 'targetAttribute' => ['COURSE_ID' => 'COURSE_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LESSON_ID' => 'Lesson ID',
            'COURSE_ID' => 'Course Name',
            'TITLE' => 'Title',
            'CONTENT' => 'Content',
            'VIDEO_URL' => 'Video Url',
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
}