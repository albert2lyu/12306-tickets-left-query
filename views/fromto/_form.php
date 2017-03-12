<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fromto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fromto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($fromto, 'from_station_name')->textInput()->label('始发站') ?>

    <?= $form->field($fromto, 'to_station_name')->textInput()->label('终止站') ?>

    <div class="form-group">
        <?= Html::submitButton($fromto->isNewRecord ? 'Create' : 'Update', ['class' => $fromto->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
