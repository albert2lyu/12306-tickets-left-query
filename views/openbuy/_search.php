<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OpenbuySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="openbuy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'from_station_id') ?>
    <?= $form->field($model, 'to_station_id') ?>
    <?= $form->field($model, 'type') ?>
    <?= $form->field($model, 'train_number') ?>

    <?= $form->field($model, 'delay_day') ?>

    <?= $form->field($model, 'update_time') ?>

    <?= $form->field($model, 'add_time') ?>

    <?= $form->field($model, 'author') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
