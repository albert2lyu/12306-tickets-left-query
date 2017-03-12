<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DirtydataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dirtydatas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dirtydata-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                               <p>
        <?= Html::a('Load Dirty Data', ['loaddirtydata'], ['class' => 'btn btn-default']) ?>
                               </p>
    <p>
        <?= Html::a('Load All Dirty Data', ['loadall'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Create Dirtydata', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            'train_number',
            [
                'attribute'=>'from_station_id',
                'label'=>'始发站',
                'value'=>function($model){
                    return $model->from->name;
                }
            ],
            [
                'attribute'=>'to_station_id',
                'label'=>'终止站',
                'value'=>function($model){
                    return $model->to->name;
                }
            ],
            'hardbed',
            'hardseat',
            'date',
            'create_time',
            // 'author',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
