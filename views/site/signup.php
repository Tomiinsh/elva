<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = 'Lietotāja reģistrācija';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Lūdzu aizpildi sekojošos laukus, lai reģistrētos sistēmā:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['autofocus' => true])->label('Lietotājvārds') ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Parole') ?>

    <?= $form->field($model, 'password_repeat')->passwordInput()->label('Parole atkārtoti') ?>

    <?= $form->field($model, 'first_name')->textInput(['autofocus' => true])->label('Vārds') ?>

    <?= $form->field($model, 'last_name')->textInput(['autofocus' => true])->label('Uzvārds') ?>

    <?= $form->field($model, 'date_of_birth')->widget(DatePicker::className(), [
        'name' => 'date_of_birth',
        'value' => date('d-M-Y', strtotime('+2 days')),
        'pluginOptions' => [
            'format' => 'dd-M-yyyy',
            'todayHighlight' => true
        ]
    ])->label('Dzimšanas datums') ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Reģistrēties', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
