<?php

use app\models\PrintTypes;
use yii\helpers\Html;
use yii\widgets\DetailView;
use barcode\barcode\BarcodeGenerator;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Заказ №'.$model->fullId;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить заказ?',
                'method' => 'post',
            ],
        ]); ?>
        <?php echo Html::a('Печать ШК', '#', ['class' => 'btn btn-warning', 'id' => 'print-barcodes-to-order', 'data-id' => $model->id]); ?>
        <?php
            $barcodes = 10;
            echo '<select id="select-values-barcode" class="form-control" style="width: auto; display: inline">';
            for($i = 1; $i <= $barcodes; $i++) {
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            echo '</select>';
        ?>
    </p>
    <?php //if(!isset($_GET['new'])) : ?>
    <?php if(false) : ?>
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id',
                'value' => $model->fullId,
            ],
            [
                'attribute' => 'payment_id',
                'value' => $model->payment ? $model->payment->name : '-',
            ],
            [
                'attribute' => 'patient_id',
                'value' => $model->patient ? Html::a($model->patient->fullName, ['patient/view', 'id' => $model->patient->id], ['target' => '_blanc']) : '-',
            ],
            'representative_name',
            'referral',
            'model',
            //'color',
            //'size',
            //'block',
            [
                'attribute' => 'shoes_id',
                'value' => $model->shoes ? $model->shoes->name : '-',
            ],
            'shoes_data',
            [
                'attribute' => 'diagnosis_id',
                'value' => $model->diagnosis ? $model->diagnosis->name : '-',
            ],
            'appointment_left',
            'appointment_left_data',
            'appointment_right',
            'appointment_right_data',
            /*[
                'attribute' => 'appointment_left_id',
                'value' => function($data) {
                    return $data->appointmentLeft ? $data->appointmentLeft->name : '';
                }
            ],
            [
                'attribute' => 'appointment_right_id',
                'value' => function($data) {
                    return $data->appointmentRight ? $data->appointmentRight->name : '';
                }
            ],*/
            'accepted',
            'issued',
            [
                'attribute' => 'Дата посл. переделки',
                'value' => function($data) {
                    return $data->getRedoneDate();
                }
            ],
            'prepaid',
            'cost',
            [
                'attribute' => 'status_id',
                'contentOptions' => [
                    'class'=>'status-row',
                    'data-value' => $model->status_id,
                ],
                'value' => $model->statusName ? $model->statusName : '-',
            ],
            [
                'attribute' => 'brand_id',
                'value' => function($data) {
                    return $data->brand ? $data->brand->name : false;
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
            'color_id',
            'color_data',
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
    ]); ?>
    <?php else : ?>
        <?php echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'id',
                    'format' => 'raw',
                    'value' => $model->fullId,
                ],
                [
                    'attribute' => 'payment_id',
                    'value' => $model->payment ? $model->payment->name : '-',
                ],
                [
                    'attribute' => 'patient_id',
                    'format' => 'raw',
                    //'value' => $model->patient ? $model->patient->full_name : '-',
                    'value' => $model->patient ? Html::a($model->patient->fullName, ['patient/view', 'id' => $model->patient->id], ['target' => '_blanc']) : '-',
                ],
                'representative_name',
                'referral',
                'model',
                [
                    'attribute' => 'shoes_id',
                    'value' => $model->shoes ? $model->shoes->name : '-',
                ],
                'shoes_data',
                [
                    'attribute' => 'diagnosis_id',
                    'value' => $model->diagnosis ? $model->diagnosis->name : '-',
                ],
                [
                    'attribute' => 'appointment_left',
                    'value' => $model->appointmentLeft ? $model->appointmentLeft->name : '-',
                ],
                'appointment_left_data',
                [
                    'attribute' => 'appointment_right',
                    'value' => $model->appointmentRight ? $model->appointmentRight->name : '-',
                ],
                'appointment_right',
                'appointment_right_data',
                'accepted',
                [
                    'attribute' => 'issued',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->issuedDates;
                    },
                ],
                [
                    'attribute' => 'Дата посл. переделки',
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->getRedoneDates();
                    }
                ],
                'prepaid',
                'cost',
                [
                    'attribute' => 'status_id',
                    'contentOptions' => [
                        'class'=>'status-row',
                        'data-value' => $model->status_id,
                    ],
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->status_id ? $data->statusName.' '.$data->lastChangeStatus() : '-';
                    },
                    //'value' => $model->statusName ? $model->statusName : '-',
                ],
                [
                    'attribute' => 'brand_id',
                    'value' => function($data) {
                        return $data->modelBrand ? $data->modelBrand->name : false;
                    }
                ],
                'brand_data',
                [
                    'attribute' => 'material_id',
                    'value' => function($data) {
                        return $data->modelMaterial ? $data->modelMaterial->name : false;
                    }
                ],
                'material_data',
                [
                    'attribute' => 'lining_id',
                    'value' => function($data) {
                        return $data->modelLining ? $data->modelLining->name : false;
                    }
                ],
                'lining_data',
                'color_id',
                'color_data',
                'heel_left',
                'heel_left_data',
                'heel_right',
                'heel_right_data',
                [
                    'attribute' => 'sole_id',
                    'value' => function($data) {
                        return $data->modelSole ? $data->modelSole->name : false;
                    }
                ],
                'sole_data',
                [
                    'attribute' => 'last_id',
                    'value' => function($data) {
                        return $data->modelLast ? $data->modelLast->name : false;
                    }
                ],
                'last_data',
            ],
        ]); ?>
    <?php endif; ?>

    <?php
        if($model->payment_id == 11)
            echo $this->render('print-links/contract_lo');
        elseif ($model->payment_id == 18)
            echo $this->render('print-links/contract_lo', ['new' => true]);
        else
            echo $this->render('print-links/default');
    ?>
    <p>
        <?php echo Html::a('Печать', null, ['class' => 'btn btn-primary print', 'data-id' => $model->id]); ?>
    </p>
    <?php if(isset($_GET['test'])) : ?>
    <?php
        $barcodeId = '0000000022100';
        echo $model->getBarcodeBlock();
    ?>
    <?php endif; ?>
</div>
