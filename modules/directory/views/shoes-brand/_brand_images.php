<?php

use himiklab\thumbnail\EasyThumbnailImage;
use kartik\widgets\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изображения для ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Модель '.$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование изображений материала '.$material->name;
$this->registerJsFile('/js/jquery-ui.min.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<h1>
    Модель <b><?= $model->name ?></b>
</h1>
<h2>
    Материал верха <b><?= $material->name ?></b>
</h2>
<?php if($colors = $model->getBrandMaterialColors($material->id)) : ?>
    <?php $form = ActiveForm::begin() ?>
        <?php foreach($colors as $color) : ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table class="circle-color-table">
                        <tr>
                            <td style="width: 240px;">
                                Изображения для цвета обуви
                                <b>
                                    <?= $model->getColor($color->color_id)->name ?>
                                </b>
                            </td>
                            <td>
                                <?= $model->getColor($color->color_id)->colorHtml ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'images_field['.$color->color_id.'][]')->widget(FileInput::classname(), [
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

                    <?php if ($colorImages = $model->getColorImages($color->color_id)): ?>
                        <div class="photo-list image-preview-container-o">
                            <?php foreach ($colorImages as $image): ?>
                                <div data-id="<?= $image->id ?>" data-path="<?= $image->path ?>" class="photo-list-item  image-preview-o">
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


        <?php endforeach; ?>
    <?= Html::submitButton('Сохранить', ['class' => "btn btn-success"]) ?>
    <?php ActiveForm::end() ?>
<?php else : ?>
    В модель обуви не добавлено ни одного цвета
<?php endif; ?>

