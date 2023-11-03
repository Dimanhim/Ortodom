<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PatientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id'); ?>

    <?php echo $form->field($model, 'full_name'); ?>

    <?php echo $form->field($model, 'representative_name'); ?>

    <?php echo $form->field($model, 'birthday'); ?>

    <?php echo $form->field($model, 'address'); ?>

    <?php // echo $form->field($model, 'phone')?>

    <?php // echo $form->field($model, 'passport_data')?>

    <?php // echo $form->field($model, 'created_at')?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']); ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
