<?php

use app\modules\directory\models\ShoesColor;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\ShoesMaterial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shoes-material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color_ids')->widget(Select2::classname(), [
        'data' => ShoesColor::getList(),
        'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
        'showToggleAll' => false,
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
