<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quiz_answers".
 *
 * @property int $ID
 * @property int $QUIZ_ID
 * @property int $QUESTION_ID
 * @property int $USER_ID
 * @property string $ANSWER_TYPE
 * @property string|null $ANSWER
 * @property string|null $USER_ANSWER
 * @property string $CREATED_AT
 *
 * @property User $iD
 * @property Questions $qUESTION
 * @property Quizzes $qUIZ
 */
class QuizAnswers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['QUIZ_ID', 'QUESTION_ID', 'USER_ID', 'ANSWER_TYPE'], 'required'],
            [['QUIZ_ID', 'QUESTION_ID', 'USER_ID'], 'integer'],
            [['ANSWER_TYPE', 'ANSWER', 'USER_ANSWER'], 'string'],
            [['CREATED_AT'], 'safe'],
            [['QUIZ_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Quizzes::class, 'targetAttribute' => ['QUIZ_ID' => 'ID']],
            [['QUESTION_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::class, 'targetAttribute' => ['QUESTION_ID' => 'ID']],
            [['ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['ID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'QUIZ_ID' => 'Quiz ID',
            'QUESTION_ID' => 'Question ID',
            'USER_ID' => 'User ID',
            'ANSWER_TYPE' => 'Answer Type',
            'ANSWER' => 'Answer',
            'USER_ANSWER' => 'User Answer',
            'CREATED_AT' => 'Created At',
        ];
    }

    /**
     * Gets query for [[ID]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getID()
    {
        return $this->hasOne(User::class, ['ID' => 'ID']);
    }

    /**
     * Gets query for [[QUESTION]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQUESTION()
    {
        return $this->hasOne(Questions::class, ['ID' => 'QUESTION_ID']);
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
}
