<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mpesa_transaction".
 *
 * @property int $id
 * @property string $phone_number
 * @property float $amount
 * @property string $transaction_status
 * @property string $request_id
 * @property string $response_code
 * @property string|null $response_description
 * @property string $created_at
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpesa_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'phone_number', 'amount', 'transaction_status', 'request_id', 'response_code'], 'required'],
            [['id'], 'integer'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['phone_number'], 'string', 'max' => 15],
            [['transaction_status'], 'string', 'max' => 20],
            [['request_id'], 'string', 'max' => 100],
            [['response_code'], 'string', 'max' => 10],
            [['response_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_number' => 'Phone Number',
            'amount' => 'Amount',
            'transaction_status' => 'Transaction Status',
            'request_id' => 'Request ID',
            'response_code' => 'Response Code',
            'response_description' => 'Response Description',
            'created_at' => 'Created At',
        ];
    }
}
