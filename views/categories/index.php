<?php

use app\models\Categories;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\CategoriesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-end">
        <p>
            <?= Html::a('Create Categories', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CATEGORY_NAME',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Categories $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'CATEGORY_ID' => $model->CATEGORY_ID]);
                }
            ],
        ],
    ]); ?>


</div>