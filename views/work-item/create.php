<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkItem */

$this->title = 'Izveidot jaunu darbu';
$this->params['breadcrumbs'][] = ['label' => 'Darbi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'construction_site_list' => $construction_site_list
    ]) ?>

</div>
