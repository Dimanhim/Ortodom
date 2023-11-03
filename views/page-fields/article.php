<?php

use app\models\ContentPage;
use himiklab\thumbnail\EasyThumbnailImage;
use kartik\widgets\FileInput;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use app\models\Config;
use app\modules\directory\models\ShoesBrand;

/* @var $model ContentPage */
/* @var $form ActiveForm */
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control page-name']) ?>
<?= $form->field($model, 'image_field')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'browseLabel' => 'Выбрать',
        'showPreview' => false,
        'showUpload' => false,
        'showRemove' => false,
    ]
]) ?>
<?php if ($model->image): ?>
    <div class="image-preview">
        <?= EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$model->image->path, 100, 100, EasyThumbnailImage::THUMBNAIL_OUTBOUND) ?>
        <p><?= Html::a('Удалить', ['images/delete', 'id' => $model->image->id], ['class' => 'btn btn-xs btn-danger']) ?></p>
    </div>
<?php endif ?>
<?= $form->field($model, 'anons_1')->widget(Summernote::class, [
    'autoFormatCode' => false,
]) ?>
<?= $form->field($model, 'anons_2')->widget(Summernote::class, [
    'autoFormatCode' => false,
]) ?>
<?= $form->field($model, 'short_description')->widget(Summernote::class, [
    'autoFormatCode' => false,
]) ?>
<?= $form->field($model, 'content')->widget(Summernote::class, [
    'autoFormatCode' => false,
]) ?>


