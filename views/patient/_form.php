<?php

//use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'full_name')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'birthday')->widget(
        DatePicker::className(), [
        'inline' => false,
        'dateFormat' => 'dd.MM.yyyy',
        'language' => 'ru',
        'options' => [
            'class' => 'form-control date-time-widget',
        ],
    ]); ?>

    <?= $form->field($model, 'address')->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => Url::to(['streets']),
            'minLength'=>'2',
        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ]) ?>

    <?php echo $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'form-control phone-mask']); ?>

    <?php echo $form->field($model, 'passport_data')->textarea(['rows' => 2]); ?>

    <div class="row">
        <div class="col-md-2">
            <?php echo $form->field($model, 'problem')->checkbox(); ?>
        </div>
        <div class="col-md-10" id="patient-problem_data-container">
            <?php echo $form->field($model, 'problem_data')->textarea(['rows' => 2]); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
