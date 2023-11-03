<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Слайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить слайдер?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            'created_at:datetime',
        ],
    ]) ?>

</div>
