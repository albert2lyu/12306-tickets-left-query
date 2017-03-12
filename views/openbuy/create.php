<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Openbuy */

$this->title = 'Create Openbuy';
$this->params['breadcrumbs'][] = ['label' => 'Openbuys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="openbuy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
