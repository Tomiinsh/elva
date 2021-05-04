<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;
use app\assets\DualListBoxAsset;

DualListBoxAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\ConstructionSite */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Būvobjekti', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("var _opts = {$items};", View::POS_BEGIN);
?>
<div class="construction-site-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atjaunot', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Dzēst', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Vai tiešām dzēst šo būvobjektu?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'location',
            'quadrature',
            'manager_id',
        ],
    ]) ?>

    <h3>Darbinieku pieejas būvobjektam</h3>
    <div class="employee-assignement-container">
        <?=
        $this->render('/misc/dual-list-box', [
            'assignUrl' => $assignUrl,
            'removeUrl' => $removeUrl
        ]);
        ?>
    </div>
