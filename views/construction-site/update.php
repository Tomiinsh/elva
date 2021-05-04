<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConstructionSite */

$this->title = 'Atjaunot būvobjektu: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Būvobjekti', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atjaunot';
?>
<div class="construction-site-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
