<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */
/* @var $orderProvider \yii\data\ActiveDataProvider */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Пациенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p class="text-right">
        <?php echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a('Создать заказ', ['/order/create', 'patient_id' => $model->id], ['class' => 'btn btn-success']); ?>
        <?php echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить пациента?',
                'method' => 'post',
            ],
        ]); ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
            'birthday',
            'address',
            'phone',
            'passport_data:ntext',
            'created_at:datetime',
        ],
    ]); ?>

    <?php Pjax::begin(); ?>
        <?php echo GridView::widget([
            'dataProvider' => $orderProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'id',
                    'value' => function ($data) {
                        return $data->fullId;
                    },
                ],
                [
                    'attribute' => 'payment_id',
                    'value' => function ($data) {
                        return $data->payment ? $data->payment->name : '-';
                    },
                ],
                [
                    'attribute' => 'patient_id',
                    'value' => function ($data) {
                        return $data->patient ? $data->patient->full_name : '-';
                    },
                ],
                'representative_name',
                'referral',
                [
                    'attribute' => 'shoes_id',
                    'value' => function ($data) {
                        return $data->shoes ? $data->shoes->name : '-';
                    },
                ],
                [
                    'attribute' => 'diagnosis_id',
                    'value' => function ($data) {
                        return $data->diagnosis ? $data->diagnosis->name : '-';
                    },
                ],
                [
                    'attribute' => 'accepted',
                    'value' => function ($data) {
                        return $data->accepted;
                    },
                ],
                [
                    'attribute' => 'issued',
                    'value' => function ($data) {
                        return $data->issued;
                    },
                ],
                'prepaid',
                'cost',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return ['/order/'.$action, 'id' => $model->id];
                    },
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
