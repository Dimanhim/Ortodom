<?php

use app\modules\directory\models\Shoes;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="config-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'shoes_id')->dropDownList(ArrayHelper::map(Shoes::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
            <?= $form->field($model, 'shoes_data')->textarea() ?>
            <?= $form->field($model, 'material_id')->dropDownList($model->getOptionArray('material_id'), ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'material_data')->textarea() ?>
            <?= $form->field($model, 'color')->dropDownList($model->colorsArray, ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'color_data')->textarea() ?>
            <?php echo $form->field($model, 'appointment_left')->textarea(); ?>
            <?php echo $form->field($model, 'appointment_left_data')->textarea(); ?>
            <?php echo $form->field($model, 'heel_left')->textarea(); ?>
            <?php echo $form->field($model, 'heel_left_data')->textarea(); ?>
            <?= $form->field($model, 'sole_id')->dropDownList($model->getOptionArray('sole_id'), ['prompt' => 'Выбрать']) ?>
            <?php echo $form->field($model, 'sole_data')->textarea(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'brand_id')->dropDownList($model->modelsList, ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'brand_data')->textarea() ?>
            <?= $form->field($model, 'lining_id')->dropDownList($model->getOptionArray('lining_id'), ['prompt' => 'Выбрать']) ?>
            <?= $form->field($model, 'lining_data')->textarea() ?>
            <div style="height: 185px;"></div>
            <?php echo $form->field($model, 'appointment_right')->textarea(); ?>
            <?php echo $form->field($model, 'appointment_right_data')->textarea(); ?>
            <?php echo $form->field($model, 'heel_right')->textarea(); ?>
            <?php echo $form->field($model, 'heel_right_data')->textarea(); ?>
            <?= $form->field($model, 'last_id')->dropDownList($model->getOptionArray('last_id'), ['prompt' => 'Выбрать']) ?>
            <?php echo $form->field($model, 'last_data')->textarea(); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
