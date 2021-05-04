<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Darbinieku uzskaites sistēma';
?>
<div class="site-index">

    <?php if(Yii::$app->user->can('admin')): ?>
    <?= Html::a('Darbinieki', ['employee/index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Būvobjekti', ['construction-site/index'], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>

    <?php if(isset($construction_site) && isset($employee_data_provider)): ?>
    <div class="my-construction-site">
        <h3>Mans būvobjekts</h3>
        <?= DetailView::widget([
            'model' => $construction_site,
            'attributes' => [
                'name',
                'location',
                'quadrature',
            ],
        ]) ?>
    </div>

    <div class="my-employees">
        <h3>Mani darbinieki</h3>

        <?= GridView::widget([
            'dataProvider' => $employee_data_provider,
            'columns' => [
                'first_name',
                'last_name',
                'date_of_birth',
            ],
        ]); ?>
    </div>
    <?php endif; ?>
    <?php if(isset($construction_site) || Yii::$app->user->can('admin'))
        {
            echo Html::a('Darbi', ['work-item/index'], ['class' => 'btn btn-primary']);
        }
    ?>
</div>
