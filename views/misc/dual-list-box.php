<?php

use yii\helpers\Html;

?>
<div class="row">
    <div class="col-lg-5">
        <input class="form-control search" data-target="available"
               placeholder="Meklēt pieejamos">
        <br/>
        <select multiple size="10" class="form-control list" data-target="available"></select>
    </div>
        <div class="col-lg-2">
            <div class="move-buttons">
                <br><br>
                <?php echo Html::a('&gt;&gt;', $assignUrl, [
                    'class' => 'btn btn-success btn-assign',
                    'data-target' => 'available',
                    'title' => 'Pievienot',
                ]); ?>
                <br/><br/>
                <?php echo Html::a('&lt;&lt;', $removeUrl, [
                    'class' => 'btn btn-danger btn-assign',
                    'data-target' => 'assigned',
                    'title' => 'Noņemt',
                ]); ?>
            </div>
        </div>
        <div class="col-lg-5">
            <input class="form-control search" data-target="assigned"
                   placeholder="Meklēt esošos">
            <br/>
            <select multiple size="10" class="form-control list" data-target="assigned"></select>
        </div>
    </div>
</div>