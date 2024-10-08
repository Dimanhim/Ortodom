<?php

use yii\helpers\Html;

$this->title = 'Статус - '. $orders[0]->statusName;
?>
<div class="outfit-container">
    <h2><?= Html::encode($this->title) ?></h2>
    <table class="table table-bordered table-outfit">
        <tr>
            <th>№ Заказа</th>
            <th>Модель</th>
            <th>Подкладка</th>
            <th>Верх обуви</th>
            <th>Цвет</th>
            <th>Размер</th>
        </tr>
        <?php if($orders) : ?>
            <?php foreach($orders as $order) : ?>
                <tr>
                    <td>
                        <?= $order->id ?>
                    </td>
                    <td>
                        <?= $order->modelBrand ? $order->modelBrand->name : '---' ?><br>
                    </td>
                    <td>
                        <?= $order->modelLining ? $order->modelLining->name : '---' ?>
                    </td>
                    <td>
                        <?= $order->modelMaterial ? $order->modelMaterial->name : '---' ?><br>
                    </td>
                    <td>
                        <?= $order->modelColor ? $order->modelColor->name : '---' ?>
                    </td>
                    <td>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Данных нет</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
