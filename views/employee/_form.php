<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\misc\RoleManager;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_birth')->widget(DatePicker::className(), [
        'name' => 'date_of_birth',
        'value' => date('d-M-Y', strtotime('+2 days')),
        'pluginOptions' => [
            'format' => 'dd-M-yyyy',
            'todayHighlight' => true
        ]
    ])->label('Dzimšanas datums') ?>

    <?= $form->field($role_manager, 'role')->dropDownList(RoleManager::getRoleArray(), ['id' => 'rolemanager-role'])->label('Loma') ?>
    <?= Html::hiddenInput('employee-id', $model->id, ['id' => 'employee-id']) ?>

    <?= $form->field($model, 'manager_id')->widget(DepDrop::classname(),
        [
            'data' => [$model->manager_id => ''],
            'pluginOptions' => [
                'placeholder' => 'Bez menedžera',
                'depends' => ['rolemanager-role'],
                'url' => Url::to(['/employee/get-manager-list']),
                'params' => ['rolemanager-role', 'employee-id'],
                'initialize' => true,
                'loadingText' => 'Ielādē menedžeru sarakstu...',
            ]
        ]
    )->label('Menedžeris') ?>

    <?= Html::hiddenInput('employee_id', $model->id) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$script = <<< JS
    $( document ).ready(function(){
        $("#employee-manager_id").on('depdrop:afterChange', function(){
            $(this).prop("disabled", false);
            console.log('initialized');
        });
    });
JS;

$this->registerJs($script);

?>