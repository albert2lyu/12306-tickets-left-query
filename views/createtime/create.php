<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Createtime */

$this->title = 'Create Createtime';
$this->params['breadcrumbs'][] = ['label' => 'Createtimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="createtime-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
