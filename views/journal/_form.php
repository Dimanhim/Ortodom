<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patient_id')->textInput() ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'status_date')->textInput() ?>

    <?= $form->field($model, 'representative_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_id')->textInput() ?>

    <?= $form->field($model, 'diagnosis_id')->textInput() ?>

    <?= $form->field($model, 'referral')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shoes_id')->textInput() ?>

    <?= $form->field($model, 'appointment_left_id')->textInput() ?>

    <?= $form->field($model, 'appointment_left_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'appointment_left')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'appointment_right_id')->textInput() ?>

    <?= $form->field($model, 'appointment_right')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'appointment_right_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'heel_left')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'heel_left_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'heel_right')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'heel_right_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'block')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accepted')->textInput() ?>

    <?= $form->field($model, 'issued')->textInput() ?>

    <?= $form->field($model, 'prepaid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'scan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shoes_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'brand_id')->textInput() ?>

    <?= $form->field($model, 'brand_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'material_id')->textInput() ?>

    <?= $form->field($model, 'material_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lining_id')->textInput() ?>

    <?= $form->field($model, 'lining_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'color_id')->textInput() ?>

    <?= $form->field($model, 'color_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sole_id')->textInput() ?>

    <?= $form->field($model, 'sole_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'last_id')->textInput() ?>

    <?= $form->field($model, 'last_data')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
