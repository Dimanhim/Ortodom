<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\Partner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Партнеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить партнера?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            [
                'attribute' => 'image_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->image) {
                        return EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$data->image->path, 100, 100, EasyThumbnailImage::THUMBNAIL_OUTBOUND);
                    }
                }
            ],
        ],
    ]) ?>

</div>
