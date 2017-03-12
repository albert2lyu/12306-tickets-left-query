<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                               <p>
  <?= Html::a('LoadData', ['loaddata'], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => 'Load data ?',
                'method' => 'post',
            ],
        ]) ?>
                               </p>
    <p>
        <?= Html::a('Create Station', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            'name',
            'code',
            'start_time',
            'update_time',
            // 'add_time',
            // 'author',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
