<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FromtoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fromtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fromto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fromto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            [
                'attribute'=>'from_station_name',
                'label'=>'始发站',
                'value'=>function($model){
                    return $model->from->name;
                }
            ],
            [
                'attribute'=>'to_station_name',
                'label'=>'终止站',
                'value'=>function($model){
                    return $model->to->name;
                }
            ],
            'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
