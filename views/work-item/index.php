<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WorkItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Darbi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Izveidot jaunu darbu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            'description:ntext',
            'construction_site_id',

            ['class' => 'yii\grid\ActionColumn', 'header' => 'Darbības'],
        ],
    ]); ?>


</div>
