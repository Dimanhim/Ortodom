<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'patient_id',
            'status_id',
            'status_date',
            'representative_name',
            'payment_id',
            'diagnosis_id',
            'referral',
            'shoes_id',
            'appointment_left_id',
            'appointment_left_data:ntext',
            'appointment_left:ntext',
            'appointment_right_id',
            'appointment_right:ntext',
            'appointment_right_data:ntext',
            'heel_left:ntext',
            'heel_left_data:ntext',
            'heel_right:ntext',
            'heel_right_data:ntext',
            'block',
            'accepted',
            'issued',
            'prepaid',
            'cost',
            'model',
            'color',
            'size',
            'scan',
            'shoes_data:ntext',
            'brand_id',
            'brand_data:ntext',
            'material_id',
            'material_data:ntext',
            'lining_id',
            'lining_data:ntext',
            'color_id',
            'color_data:ntext',
            'sole_id',
            'sole_data:ntext',
            'last_id',
            'last_data:ntext',
        ],
    ]) ?>

</div>
