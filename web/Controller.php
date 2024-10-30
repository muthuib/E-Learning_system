<?php

namespace app\web;

use yii\web\Controller as YiiController;
use yii\filters\AccessControl;

class Controller extends YiiController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Only allow authenticated users
                    ],
                ],
                'denyCallback' => function () {
                    return $this->redirect(['site/login']);
                },
            ],
        ];
    }
}