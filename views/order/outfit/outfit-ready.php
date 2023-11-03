<?php

use yii\helpers\Html;

$this->title = 'Наряд готов к отправке';
$count = 1;
?>
<div class="outfit-container">
    <h2><?= Html::encode($this->title) ?></h2>
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
                        <div class="row">
                            <div class="col-md-6">
                                <?= $order->getBarcodeView() ?>
                            </div>
                            <div class="col-md-6" style="text-align: left; font-size: 24px; margin-top: 15px;">
                                <strong><?= $order->id ?></strong>
                            </div>
                        </div>
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
</div>
