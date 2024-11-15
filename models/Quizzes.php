<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quizzes".
 *
 * @property int $ID
 * @property string $NAME
 * @property int $DURATION
 * @property string $CREATED_AT
 *
 * @property Questions[] $questions
 * @property QuizAttempts[] $quizAttempts
 */
class Quizzes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quizzes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NAME', 'DURATION'], 'required'],
            [['DURATION'], 'integer'],
            [['CREATED_AT'], 'safe'],
            [['NAME'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Quiz Title',
            'DURATION' => 'Duration',
            'CREATED_AT' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::class, ['QUIZ_ID' => 'ID']);
    }

    /**
     * Gets query for [[QuizAttempts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAttempts()
    {
        return $this->hasMany(QuizAttempts::class, ['QUIZ_ID' => 'ID']);
    }
}