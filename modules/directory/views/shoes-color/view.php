<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\ShoesColor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Цвета обуви', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoes-color-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'color',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->color) {
                        return $data->colorHtml;
                    }
                }
            ],
            [
                'attribute' => 'images_field',
                'format' => 'raw',
                'value' => function($data) {
                    $str = '';
                    if ($colorImages = $data->getColorImages()) {
                        foreach ($colorImages as $image) {
                            if($image->path) {
                                $str .= EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$image->path, 160, 160, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
                            }
                        }
                    }
                    return $str;
                }
            ],
            'created_at:datetime',
        ],
    ]) ?>

</div>
