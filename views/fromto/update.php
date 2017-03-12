<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fromto */

$this->title = 'Update Fromto: ' . ' ' . $fromto->Id;
$this->params['breadcrumbs'][] = ['label' => 'Fromtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $fromto->Id, 'url' => ['view', 'id' => $fromto->Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fromto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'fromto' => $fromto
    ]) ?>

</div>
