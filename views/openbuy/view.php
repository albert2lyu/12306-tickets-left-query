<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Openbuy */

$this->params['breadcrumbs'][] = ['label' => 'Openbuys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="openbuy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'from_station_id',
            'to_station_id',
            'train_number',
            'delay_day',
            'type',
            'update_time',
            'add_time',
            'author',
        ],
    ]) ?>

</div>
