<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CreatetimeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Createtimes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="createtime-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Createtime', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            'openbuy_id',
            'increased',
            'create_time',
            'author',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
