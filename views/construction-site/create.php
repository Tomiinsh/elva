<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConstructionSite */

$this->title = 'Izveidot būvobjektu';
$this->params['breadcrumbs'][] = ['label' => 'Būvobjekti', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
