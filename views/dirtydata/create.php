<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dirtydata */

$this->title = 'Create Dirtydata';
$this->params['breadcrumbs'][] = ['label' => 'Dirtydatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dirtydata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
