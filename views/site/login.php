<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Pierakstīties sistēmā';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Lūdzu aizpildi zemāk esošos laukus, lai pierakstītos sistēmā:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Pierakstīties', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <p>
        <b>Lai pierakstītos kā administrators:</b><br>
        administrator/administrator<br>
        <br>
        <b>Lai pieteiktos kā objekta menedžeris:</b><br>
        manager/employee2<br>
        manager1/manager1<br>
        manager2/manager2<br>
        <br>
        <b>Lai pieteiktos kā darbinieks:</b><br>
        employee/employee<br>
        employee1/employee1<br>
        ...<br>
        employee6/employee6<br>
    </p>

    <b>Lai iegūtu informāciju par būvobjektu, noskaidrot tā ID un izmantot saiti:</b><br>
    /api/get-construction-site-info?id=&ltbūvobjekta_id&gt
</div>
