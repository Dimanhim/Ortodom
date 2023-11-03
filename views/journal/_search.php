<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JournalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'patient_id') ?>

    <?= $form->field($model, 'status_id') ?>

    <?= $form->field($model, 'status_date') ?>

    <?= $form->field($model, 'representative_name') ?>

    <?php // echo $form->field($model, 'payment_id') ?>

    <?php // echo $form->field($model, 'diagnosis_id') ?>

    <?php // echo $form->field($model, 'referral') ?>

    <?php // echo $form->field($model, 'shoes_id') ?>

    <?php // echo $form->field($model, 'appointment_left_id') ?>

    <?php // echo $form->field($model, 'appointment_left_data') ?>

    <?php // echo $form->field($model, 'appointment_left') ?>

    <?php // echo $form->field($model, 'appointment_right_id') ?>

    <?php // echo $form->field($model, 'appointment_right') ?>

    <?php // echo $form->field($model, 'appointment_right_data') ?>

    <?php // echo $form->field($model, 'heel_left') ?>

    <?php // echo $form->field($model, 'heel_left_data') ?>

    <?php // echo $form->field($model, 'heel_right') ?>

    <?php // echo $form->field($model, 'heel_right_data') ?>

    <?php // echo $form->field($model, 'block') ?>

    <?php // echo $form->field($model, 'accepted') ?>

    <?php // echo $form->field($model, 'issued') ?>

    <?php // echo $form->field($model, 'prepaid') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'scan') ?>

    <?php // echo $form->field($model, 'shoes_data') ?>

    <?php // echo $form->field($model, 'brand_id') ?>

    <?php // echo $form->field($model, 'brand_data') ?>

    <?php // echo $form->field($model, 'material_id') ?>

    <?php // echo $form->field($model, 'material_data') ?>

    <?php // echo $form->field($model, 'lining_id') ?>

    <?php // echo $form->field($model, 'lining_data') ?>

    <?php // echo $form->field($model, 'color_id') ?>

    <?php // echo $form->field($model, 'color_data') ?>

    <?php // echo $form->field($model, 'sole_id') ?>

    <?php // echo $form->field($model, 'sole_data') ?>

    <?php // echo $form->field($model, 'last_id') ?>

    <?php // echo $form->field($model, 'last_data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
