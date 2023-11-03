<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\ShoesBrand */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Модели обуви', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoes-brand-view">

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
                'attribute' => 'shoes_id',
                'value' => function($data) {
                    if($data->shoes) return $data->shoes->name;
                }
            ],
            [
                'attribute' => 'age_group_id',
                'value' => function($data) {
                    return $data->ageGroupNames;
                }
            ],
            [
                'attribute' => 'material_id',
                'value' => function($data) {
                    return $data->materialNames;
                }
            ],
            [
                'attribute' => 'lining_id',
                'value' => function($data) {
                    return $data->liningNames;
                }
            ],
            [
                'attribute' => 'sole_id',
                'value' => function($data) {
                    return $data->soleNames;
                }
            ],
            [
                'attribute' => 'color_ids',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getColorsString();
                }
            ],
            [
                'attribute' => 'siteLink',
                'format' => 'raw',
            ],
            'created_at:datetime',
        ],
    ]) ?>

</div>
