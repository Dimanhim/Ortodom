<?php

use yii\helpers\Html;

$this->title = 'Наряд крой';
$count = 1;
?>

<div class="outfit-container">
    <h2><?= Html::encode($this->title) ?></h2>
    <table class="table table-bordered table-outfit">
        <tr>
            <th></th>
            <th>№ Заказа</th>
            <th>Модель</th>
            <th>Подкладка</th>
            <th>Верх</th>
            <th>Цвет</th>
            <th>Размер/крой</th>
        </tr>
        <?php if($orders) : ?>
            <?php foreach($orders as $order) : ?>
                <tr>
                    <td class="number">
                        <?= $count ?>
                    </td>
                    <td>
                        <?= $order->id ?>
                    </td>
                    <td>
                        <?= $order->modelName ?>
                    </td>
                    <td>
                        <?= $order->modelLining ? $order->modelLining->name : '---' ?>
                    </td>
                    <td>
                        <?= $order->modelMaterial ? $order->modelMaterial->name : '---' ?>
                    </td>
                    <td class="color-row">
                        <?= $order->getColorDataName() ?>
                    </td>
                    <td>

                    </td>
                </tr>
            <?php $count++ ?>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7">Данных нет</td>
            </tr>
        <?php endif; ?>
    </table>
    <?= $this->render('operation-list', ['orders' => $orders]) ?>
</div>
<style>
    h2 {
        margin-top: 0;
    }
    table tr td.number {
        width: 6.41%;
    }
    table tr td {
        width: 12.8205%;
    }
    table tr td.color-row {
        width: 35.8974%;
    }
</style>
