<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="representative-edit">
    <h2><?= $model->isNewRecord ? 'Создание' : 'Редактирование' ?> представителя</h2>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'name')->textInput(['placeholder' => "ФИО"]) ?>
    <?= $form->field($model, 'passport_data')->textarea() ?>
    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput(['value' => $model->id]) ?>
    <?= $form->field($model, 'patient_id', ['template' => '{input}'])->hiddenInput(['value' => $model->patient_id]) ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-representative-save']) ?>
    <?php ActiveForm::end() ?>

</div>
