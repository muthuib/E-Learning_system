<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property int $ID
 * @property int $QUIZ_ID
 * @property string $CONTENT
 *
 * @property Answers[] $answers
 * @property Quizzes $qUIZ
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['QUIZ_ID', 'CONTENT', 'ANSWER_TYPE'], 'required'],
            [['QUIZ_ID'], 'integer'],
            [['CONTENT'], 'string'],
            [['ANSWER_TYPE'], 'string'],
            
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
            'QUIZ_ID' => 'Quiz ID',
            'CONTENT' => 'Content',
            'ANSWER_TYPE' => 'Answer Type',
            
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::class, ['QUESTION_ID' => 'ID']);
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