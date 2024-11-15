<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quiz_attempts".
 *
 * @property int $ID
 * @property int $USER_ID
 * @property int $QUIZ_ID
 * @property string $START_TIME
 * @property string|null $END_TIME
 * @property float|null $SCORE
 *
 * @property Quizzes $qUIZ
 * @property User $uSER
 */
class QuizAttempts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_attempts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['USER_ID', 'QUIZ_ID'], 'required'],
            [['USER_ID', 'QUIZ_ID'], 'integer'],
            [['START_TIME', 'END_TIME'], 'safe'],
            [['SCORE'], 'number'],
            [['USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['USER_ID' => 'ID']],
            [['QUIZ_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Quizzes::class, 'targetAttribute' => ['QUIZ_ID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'USER_ID' => 'User ID',
            'QUIZ_ID' => 'Quiz ID',
            'START_TIME' => 'Start Time',
            'END_TIME' => 'End Time',
            'SCORE' => 'Score',
        ];
    }

    /**
     * Gets query for [[QUIZ]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQUIZ()
    {
        return $this->hasOne(Quizzes::class, ['ID' => 'QUIZ_ID']);
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