<?php

use yii\helpers\Html;
use yii\grid\GridView;
use himiklab\thumbnail\EasyThumbnailImage;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайдеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'banner_img_bg_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($image = $data->backgroundImage) {
                        return $image->previewHtml;
                    }
                }
            ],
            [
                'attribute' => 'banner_img_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($image = $data->mainImage) {
                        return $image->previewHtml;
                    }
                }
            ],
            [
                'attribute' => 'banner_info_img_id',
                'format' => 'raw',
                'value' => function($data) {
                    if($image = $data->imageInfo) {
                        return $image->previewHtml;
                    }
                }
            ],
            'title',
            'name',
            'sub_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
