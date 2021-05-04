<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = 'Atjaunot darbinieku: ' . $model->first_name . " " . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Darbinieks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atjaunot';
?>
<div class="employee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'role_manager' => $role_manager,
    ]) ?>

</div>
