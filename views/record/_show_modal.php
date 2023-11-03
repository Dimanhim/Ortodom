<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="modal" id="visitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="form">
                    <div style="padding: 10px 0; font-size:18px">
                        Запись на прием <b><span id="time-value"></span> <span id="date-value"></span></b>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'form-visit', 'options' => ['class' => 'form send-data']])?>
                    <?= $form->field($model, 'phone')->textInput(['placeholder' => "+7-888-888-88-88", 'class' => 'form-control auto-phone']) ?>
                    <?= $form->field($model, 'name')->textInput(['placeholder' => "Имя"]) ?>
                    <?= $form->field($model, 'visit_time', ['template' => '{input}'])->hiddenInput() ?>
                    <?= $form->field($model, 'visit_date', ['template' => '{input}'])->hiddenInput() ?>
                    <?= $form->field($model, 'patient_id', ['template' => '{input}'])->hiddenInput() ?>
                    <?= Html::submitButton('Записать', ['class' => "btn btn-success"]) ?>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
