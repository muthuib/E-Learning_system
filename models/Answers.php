<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property int $ID
 * @property int $QUESTION_ID
 * @property string $CONTENT
 * @property int|null $IS_CORRECT
 *
 * @property Questions $qUESTION
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['QUESTION_ID', 'CONTENT'], 'required'],
            [['QUESTION_ID', 'IS_CORRECT'], 'integer'],
            [['CONTENT'], 'string', 'max' => 255],
            [['QUESTION_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::class, 'targetAttribute' => ['QUESTION_ID' => 'ID']],
            [['TYPED_ANSWER '], 'string', 'max' => 255], // If you're using text for typed answers
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'QUESTION_ID' => 'Question ID',
            'CONTENT' => 'Content',
            'IS_CORRECT' => 'Is Correct',
        ];
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
}