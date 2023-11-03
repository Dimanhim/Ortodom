<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin(); ?>

            <?php if ($model && ($image = $model->backgroundImage)): ?>
                <?= $image->previewsHtml ?>
            <?php endif ?>

            <?= $form->field($model, 'banner_img_bg_id')->widget(FileInput::className(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'browseLabel' => 'Выбрать',
                    'showPreview' => false,
                    'showUpload' => false,
                    'showRemove' => false,
                ]
            ]) ?>

            <?php if ($model && ($image = $model->mainImage)): ?>
                <?= $image->previewsHtml ?>
            <?php endif ?>

            <?= $form->field($model, 'banner_img_id')->widget(FileInput::className(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'browseLabel' => 'Выбрать',
                    'showPreview' => false,
                    'showUpload' => false,
                    'showRemove' => false,
                ]
            ]) ?>

            <?php if ($model && ($image = $model->imageInfo)): ?>
                <?= $image->previewsHtml ?>
            <?php endif ?>

            <?= $form->field($model, 'banner_info_img_id')->widget(FileInput::className(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'browseLabel' => 'Выбрать',
                    'showPreview' => false,
                    'showUpload' => false,
                    'showRemove' => false,
                ]
            ]) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'sub_name')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>


</div>
