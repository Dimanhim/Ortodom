<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\directory\models\ShoesBrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модели обуви';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoes-brand-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить модель', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
