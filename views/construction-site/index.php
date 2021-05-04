<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConstructionSiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Būvobjekti';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Izveidot būvobjektu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            'location',
            'quadrature',
            'manager_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
