<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $CATEGORY_ID
 * @property string $CATEGORY_NAME
 *
 * @property Courses[] $cOURSEs
 * @property CourseCategories[] $courseCategories
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CATEGORY_NAME'], 'required'],
            [['CATEGORY_NAME'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CATEGORY_ID' => 'Category ID',
            'CATEGORY_NAME' => 'Category Name',
        ];
    }

    /**
     * Gets query for [[COURSEs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCOURSEs()
    {
        return $this->hasMany(Courses::class, ['COURSE_ID' => 'COURSE_ID'])->viaTable('course_categories', ['CATEGORY_ID' => 'CATEGORY_ID']);
    }

    /**
     * Gets query for [[CourseCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseCategories()
    {
        return $this->hasMany(CourseCategories::class, ['CATEGORY_ID' => 'CATEGORY_ID']);
    }
}
