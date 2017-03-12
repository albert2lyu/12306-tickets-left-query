<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Openbuy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="openbuy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_station_name')->textInput() ?>

    <?= $form->field($model, 'to_station_name')->textInput() ?>

    <?= $form->field($model, 'delay_day')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
