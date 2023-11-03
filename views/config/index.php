<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Конфигуратор';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать конфигурацию', ['create'], ['class' => 'btn btn-success']) ?>
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
                    return $data->shoes ? $data->shoes->name : '';
                }
            ],
            'brand_id',
            [
                'attribute' => 'material_id',
                'value' => function($data) {
                    return $data->getOptionName('material_id');
                }
            ],
            [
                'attribute' => 'lining_id',
                'value' => function($data) {
                    return $data->getOptionName('lining_id');
                }
            ],
            'color',
            // 'appointment_left:ntext',
            // 'appointment_right:ntext',
            // 'heel_left',
            // 'heel_right',
            [
                'attribute' => 'sole_id',
                'value' => function($data) {
                    return $data->getOptionName('sole_id');
                }
            ],
            [
                'attribute' => 'last_id',
                'value' => function($data) {
                    return $data->getOptionName('last_id');
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
