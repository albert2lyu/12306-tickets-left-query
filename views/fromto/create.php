<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fromto */

$this->title = 'Create Fromto';
$this->params['breadcrumbs'][] = ['label' => 'Fromtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fromto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'fromto'  => $fromto,
    ]) ?>

</div>
