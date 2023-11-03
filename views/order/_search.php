<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id'); ?>

    <?php echo $form->field($model, 'payment_id'); ?>

    <?php echo $form->field($model, 'patient_id'); ?>

    <?php echo $form->field($model, 'referral'); ?>

    <?php // echo $form->field($model, 'diagnosis_id')?>

    <?php // echo $form->field($model, 'accepted')?>

    <?php // echo $form->field($model, 'issued')?>

    <?php // echo $form->field($model, 'prepaid')?>

    <?php // echo $form->field($model, 'cost')?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']); ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
