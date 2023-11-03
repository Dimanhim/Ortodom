<?php

use dosamigos\datepicker\DatePicker;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\ShoesColor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shoes-color-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Основная информация
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?php echo $form->field($model, 'color')->widget(ColorInput::className(), [
                        'options' => ['placeholder' => 'Выберите цвет'],

                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Изображения
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'images_field[]')->widget(FileInput::classname(), [
                        'options' => [
                            'multiple' => true,
                            'accept' => 'image/*'
                        ],
                        'pluginOptions' => [
                            'browseLabel' => 'Выбрать',
                            //'showPreview' => false,
                            'showUpload' => false,
                            'showRemove' => false,
                        ]
                    ])->label(false); ?>

                    <?php if ($colorImages = $model->getColorImages()): ?>
                        <div class="photo-list">
                            <?php foreach ($colorImages as $image): ?>
                                <div data-id="<?= $image->id ?>" data-path="<?= $image->path ?>" class="photo-list-item">
                                    <div>
                                        <?= EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$image->path, 160, 160, EasyThumbnailImage::THUMBNAIL_OUTBOUND) ?>
                                    </div>
                                    <div class="photo-list-btns">
                                        <?= Html::a('Удалить', ['delete-image', 'id' => $image->id], ['class' => 'btn btn-xs btn-danger delete-image']) ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>









    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
