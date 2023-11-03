<?php

use app\models\Patient;
use app\modules\directory\models\Shoes;
use vova07\select2\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="config-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo $form->field($model, 'shoes_id')->dropDownList(ArrayHelper::map(Shoes::find()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
            <?php echo $form->field($model, 'shoes_data')->textarea(['maxlength' => true]) ?>
            <?= $form->field($model, 'brand_id')->dropDownList($model->modelsList, ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'brand_data')->textarea() ?>
            <?= $form->field($model, 'lining_id')->dropDownList($model->getOptionArray('lining_id'), ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'lining_data')->textarea() ?>
            <?= $form->field($model, 'material_id')->dropDownList($model->getOptionArray('material_id'), ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'material_data')->textarea() ?>
            <?= $form->field($model, 'color')->dropDownList($model->colorsArray, ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'color_data')->textarea() ?>
            <?= $form->field($model, 'sole_id')->dropDownList($model->getOptionArray('sole_id'), ['prompt' => 'Выбрать']) ?>
            <?php echo $form->field($model, 'sole_data')->textarea(); ?>
            <?= $form->field($model, 'last_id')->dropDownList($model->getOptionArray('last_id'), ['prompt' => 'Выбрать']) ?>
            <?php echo $form->field($model, 'last_data')->textarea(); ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-order-form">
                <tr>
                    <td class="table-order-left">
                        <?php echo $form->field($model, 'appointment_left')->dropDownList($model->appointmentLeftArray(), ['prompt' => 'Выбрать']) ?>
                    </td>
                    <td class="table-order-arrow table-order-arrow-full">
                        <a href="#" class="arrow-left arrow-select">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                        </a>
                    </td>
                    <td class="table-order-arrow table-order-arrow-full">
                        <a href="#" class="arrow-right arrow-select">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </td>
                    <td class="table-order-right">
                        <?php echo $form->field($model, 'appointment_right')->dropDownList($model->appointmentRightArray(), ['prompt' => 'Выбрать']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-order-left">
                        <?php echo $form->field($model, 'appointment_left_data')->textInput(['maxlength' => true])->label(false); ?>
                    </td>
                    <td class="table-order-arrow table-order-arrow-short">
                        <a href="#" class="arrow-left arrow-input">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                        </a>
                    </td>
                    <td class="table-order-arrow table-order-arrow-short">
                        <a href="#" class="arrow-right arrow-input">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </td>
                    <td class="table-order-right">
                        <?php echo $form->field($model, 'appointment_right_data')->textInput(['maxlength' => true])->label(false); ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-order-left">
                        <?php echo $form->field($model, 'heel_left')->dropDownList($model->heelLeftArray(), ['prompt' => 'Выбрать']) ?>
                    </td>
                    <td class="table-order-arrow table-order-arrow-full">
                        <a href="#" class="arrow-left arrow-select">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                        </a>
                    </td>
                    <td class="table-order-arrow table-order-arrow-full">
                        <a href="#" class="arrow-right arrow-select">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </td>
                    <td class="table-order-right">
                        <?php echo $form->field($model, 'heel_right')->dropDownList($model->heelRightArray(), ['prompt' => 'Выбрать']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-order-left">
                        <?php echo $form->field($model, 'heel_left_data')->textInput(['maxlength' => true])->label(false); ?>
                    </td>
                    <td class="table-order-arrow table-order-arrow-short">
                        <a href="#" class="arrow-left arrow-input">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                        </a>
                    </td>
                    <td class="table-order-arrow table-order-arrow-short">
                        <a href="#" class="arrow-right arrow-input">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </td>
                    <td class="table-order-right">
                        <?php echo $form->field($model, 'heel_right_data')->textInput(['maxlength' => true])->label(false); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Фото модели итоговой
        </div>
        <div class="panel-body">
            <?= $model->modelImageBlock() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить конфигурацию' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Действия
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <tr>
                            <td style="width: 340px">
                                <?= Html::submitButton('Добавить конфигурацию в заказ для пациента', ['class' => 'btn btn-success', 'name' => 'addConfigOrder', 'value' => 1, 'style' => 'margin-top: 20px;']) ?>
                            </td>
                            <td>
                                <?php /*echo  $form->field($model, 'patient_id')->widget(Widget::className(), [
                                    'options' => [
                                        'multiple' => false,
                                        'placeholder' => 'Выбрать',
                                    ],
                                    'settings' => [
                                        'width' => '100%',
                                    ],
                                    'items' => ArrayHelper::map(Patient::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'),
                                ]);*/ ?>
                                <?= $form->field($model, 'patient_id')->dropDownList(ArrayHelper::map(Patient::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'), ['prompt' => '--Выбрать--', 'class' => 'form-control chosen']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?= Html::submitButton('Создать этот заказ нового пациента', ['class' => 'btn btn-success', 'name' => 'addConfigNewPatient', 'value' => 1]) ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

