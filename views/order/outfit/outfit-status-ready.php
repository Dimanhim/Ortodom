<?php

use yii\helpers\Html;

$this->title = 'Наряд готов к отправке';
$count = 1;
?>
<div class="outfit-container">
    <div class="row">
        <div class="col-md-6">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <?= date('d.m.Y') ?>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-outfit">
        <tr>
            <th>№ п/п</th>
            <th>ФИО</th>
            <th>Номер заказа и ШК</th>
        </tr>
        <?php if($orders) : ?>
            <?php foreach($orders as $order) : ?>
                <tr>
                    <td>
                        <?= $count ?>
                    </td>
                    <td>
                        <?= $order->patient ? $order->patient->full_name : '---' ?>
                    </td>
                    <td>
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <?= $order->getBarcodeView() ?>
                                </td>
                                <td style="text-align: left; font-size: 24px; margin-top: 15px;">
                                    <strong><?= $order->id ?></strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php $count++ ?>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="3">Данных нет</td>
            </tr>
        <?php endif; ?>
    </table>
    <?= $this->render('operation-list', ['orders' => $orders]) ?>
</div>
<style>
    h2 {
        margin-top: 0;
    }
</style>
