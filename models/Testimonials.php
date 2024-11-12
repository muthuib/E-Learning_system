<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testimonials".
 *
 * @property int $id
 * @property string $name
 * @property string $message
 * @property string $date
 * @property int|null $status
 */
class Testimonials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testimonials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'message', 'date'], 'required'],
            [['message'], 'string'],
            [['date'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'message' => 'Message',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }
}
