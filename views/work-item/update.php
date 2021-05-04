<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkItem */

$this->title = 'Atjaunot darbu: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Darbi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atjaunot';
?>
<div class="work-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'construction_site_list' => $construction_site_list
    ]) ?>

</div>
