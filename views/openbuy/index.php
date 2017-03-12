<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Station;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OpenbuySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Openbuys';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="openbuy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Openbuy', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'Id',
            [ 'attribute'=>'from_station_id',
              'label'=>'始发站',
              'value'=>function($model){
                  return $model->from->name;
              }
            ],
            [ 'attribute'=>'to_station_id',
              'label'=>'终止站',
              'value'=>function($model){
                  return $model->to->name;
              }
            ],
            'train_number',
            'delay_day',
            'type',
            'count',
            'update_time',
            'add_time',
            'author',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
