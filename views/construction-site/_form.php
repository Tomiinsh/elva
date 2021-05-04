<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConstructionSite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="construction-site-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quadrature')->textInput() ?>

    <?= $form->field($model, 'manager_id')->dropDownList([])->label('Menedžeris') ?>

    <div class="form-group">
        <?= Html::submitButton('Saglabāt', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$script = <<< JS
    $( document ).ready(function(){
        let managerInputField = $('#constructionsite-manager_id');
        var url = '/employee/get-manager-list'; 
        $.ajax({
            url: url,
            success: function(response) {
                $.each(response.output,function(key, value) {
                    $(managerInputField).append('<option value=' + value.id + '>' + value.name + '</option>');
                });
            }
        });
       
    });
JS;

$this->registerJs($script);

?>