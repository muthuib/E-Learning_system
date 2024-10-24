<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grades".
 *
 * @property int $GRADE_ID
 * @property int|null $SUBMISSION_ID
 * @property float $GRADE
 * @property string $GRADED_AT
 *
 * @property Submissions $sUBMISSION
 */
class Grades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SUBMISSION_ID'], 'integer'],
            [['GRADE'], 'required'],
            [['GRADE'], 'number'],
            [['GRADED_AT'], 'safe'],
            [['SUBMISSION_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Submissions::class, 'targetAttribute' => ['SUBMISSION_ID' => 'SUBMISSION_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'GRADE_ID' => 'Grade ID',
            'SUBMISSION_ID' => 'Submission ID',
            'GRADE' => 'Grade',
            'GRADED_AT' => 'Graded At',
        ];
    }

    /**
     * Gets query for [[SUBMISSION]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSUBMISSION()
    {
        return $this->hasOne(Submissions::class, ['SUBMISSION_ID' => 'SUBMISSION_ID']);
    }
}
