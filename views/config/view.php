<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Config */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Конфигуратор', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данную конфигурацию?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Добавить заказ', ['order/create', 'config_id' => $model->id, 'new' => 1], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'shoes_id',
                'value' => function($data) {
                    return $data->shoes ? $data->shoes->name : '';
                }
            ],
            'shoes_data',
            [
                'attribute' => 'brand_id',
                'value' => function($data) {
                    return $data->getOptionName('brand_id');
                }
            ],
            'brand_data',
            [
                'attribute' => 'material_id',
                'value' => function($data) {
                    return $data->getOptionName('material_id');
                }
            ],
            'material_data',
            [
                'attribute' => 'lining_id',
                'value' => function($data) {
                    return $data->getOptionName('lining_id');
                }
            ],
            'lining_data',
            'color',
            'color_data',
            'appointment_left:ntext',
            'appointment_left_data',
            'appointment_right:ntext',
            'appointment_right_data',
            'heel_left',
            'heel_left_data',
            'heel_right',
            'heel_right_data',
            [
                'attribute' => 'sole_id',
                'value' => function($data) {
                    return $data->getOptionName('sole_id');
                }
            ],
            'sole_data',
            [
                'attribute' => 'last_id',
                'value' => function($data) {
                    return $data->getOptionName('last_id');
                }
            ],
            'last_data',
        ],
    ]) ?>

</div>
