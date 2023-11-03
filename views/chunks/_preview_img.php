<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;

?>

<div class="container-fluid photo-list-item">
    <div class="image-preview-container">
        <div class="row image-preview-container-o">
            <div class="col-3 image-preview image-preview-o" data-id="<?= $image->id ?>">
                <div class="image-preview-content">
                    <?/*= EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$image->path, 300, 100, EasyThumbnailImage::THUMBNAIL_OUTBOUND)*/ ?>
                    <div style="border: 1px solid #ddd">
                        <img src="<?= $image->path ?>" style="max-height: 100px;" alt="">
                    </div>

                    <p>
                        <?= Html::a('Удалить', ['images/delete', 'id' => $image->id], ['class' => 'btn btn-sm btn-danger delete-image delete-image-o', 'data-confirm' => 'Удалить файл?']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
