<?php

use app\models\Employee;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Mani darbi';

$employee = Employee::findOne(Yii::$app->user->identity->employee_id);
$work_items = new ActiveDataProvider([
    'query' => $employee->getWorkItems(),
    'sort' => ['attributes' => ['name', 'construction_site_id']]
]);

?>
<h1>Mans darbu saraksts</h1>
<div class="my-work">
    <?=
    GridView::widget([
        'dataProvider' => $work_items,
        'columns' => ['name', 'description', 'construction_site_id']
    ]);
    ?>
</div>
