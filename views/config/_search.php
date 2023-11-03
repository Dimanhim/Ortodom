<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'brand_id') ?>

    <?= $form->field($model, 'material_id') ?>

    <?php // echo $form->field($model, 'lining_id') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'appointment_left') ?>

    <?php // echo $form->field($model, 'appointment_right') ?>

    <?php // echo $form->field($model, 'heel_left') ?>

    <?php // echo $form->field($model, 'heel_right') ?>

    <?php // echo $form->field($model, 'sole_id') ?>

    <?php // echo $form->field($model, 'last_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
