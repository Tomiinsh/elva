<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;
use app\assets\DualListBoxAsset;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\WorkItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Darbi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
DualListBoxAsset::register($this);
$this->registerJs("var _opts = {$items};", View::POS_BEGIN);

?>
<div class="work-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atjaunot', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Dzēst', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Vai tiešām dzēst šo darbu?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'construction_site_id',
        ],
    ]) ?>

    <div class="work-item-assignement">
        <?=
        $this->render('/misc/dual-list-box', [
            'assignUrl' => $assignUrl,
            'removeUrl' => $removeUrl
        ]);
        ?>
    </div>

</div>
