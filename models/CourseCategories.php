<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course_categories".
 *
 * @property int $COURSE_ID
 * @property int $CATEGORY_ID
 *
 * @property Categories $cATEGORY
 * @property Courses $cOURSE
 */
class CourseCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['COURSE_ID', 'CATEGORY_ID'], 'required'],
            [['COURSE_ID', 'CATEGORY_ID'], 'integer'],
            [['COURSE_ID', 'CATEGORY_ID'], 'unique', 'targetAttribute' => ['COURSE_ID', 'CATEGORY_ID']],
            [['CATEGORY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['CATEGORY_ID' => 'CATEGORY_ID']],
            [['COURSE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::class, 'targetAttribute' => ['COURSE_ID' => 'COURSE_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'COURSE_ID' => 'Course ID',
            'CATEGORY_ID' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[CATEGORY]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCATEGORY()
    {
        return $this->hasOne(Categories::class, ['CATEGORY_ID' => 'CATEGORY_ID']);
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
