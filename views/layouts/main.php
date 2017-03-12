<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
$isGuest =  Yii::$app->user->isGuest;
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            $isGuest ? "" : ['label' => 'From To', 'url' => ['/fromto/index']],
            $isGuest ? "" : ['label' => 'DirtyData', 'url' => ['/dirtydata/index']],
            $isGuest ? "" : ['label' => 'OpenBuy', 'url' => ['/openbuy/index']],
            $isGuest ? "" : ['label' => 'Create Time', 'url' => ['/createtime/index']],
            $isGuest ? "" : ['label' => 'Station', 'url' => ['/station/index']],
            $isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li style="margin:10px 5px;">'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '注销',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
