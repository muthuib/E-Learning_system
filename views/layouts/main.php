<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\web\View;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerJsFile('@web/js/jquery.min.js', ['position' => View::POS_HEAD]);

// Register custom CSS for alert positioning
$this->registerCss('
    .alert {
        position: fixed;
        top: 100px;
        left: 60%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 900px;
        z-index: 1050; /* Ensures it stays on top */
        margin-bottom: 20px;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    .alert-dismissible .close {
        color: white;
        opacity: 1;
    }

    // .alert-success {
    //     background-color: #28a745;
    //     color: white;
    // }

    // .alert-danger {
    //     background-color: #dc3545;
    //     color: white;
    // }
');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <?php
    // Inside <head> tag of your layout (main.php)
    $this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
    ?>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <?php echo $this->render('/dashboard/header') ?>
    <?php
    if (!Yii::$app->user->isGuest) {
        echo $this->render('/dashboard/sidebar');
    }
    ?>

    <!-- Place alert widget outside content for visibility -->
    <div style="max-width: 900px; position: relative;">
        <?= Alert::widget() ?>
    </div>

    <?php if (!Yii::$app->user->isGuest) : ?>
    <main id="main" class="main">
        <div class="container">
            <div class="pagetitle">
                <?php if (!empty($this->params['breadcrumbs'])) : ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
                <?php endif ?>
            </div>
        </div>
        <?php endif; ?>
        <?= $content ?>
    </main>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>