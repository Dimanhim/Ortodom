<?php

use yii\helpers\Html;

$this->title = 'Наряд затяжка';
?>
<div class="outfit-container">
    <h2><?= Html::encode($this->title) ?></h2>
    <table class="table table-bordered table-outfit">
        <tr>
            <th>№ Заказа</th>
            <th>Колодка и размер</th>
            <th>Модель и подкладка</th>
            <th>Верх обуви и цвета</th>
            <th>Подошва</th>
        </tr>
        <?php if($orders) : ?>
            <?php foreach($orders as $order) : ?>
                <tr>
                    <td>
                        <?= $order->id ?>
                    </td>
                    <td>

                    </td>
                    <td>
                        <?= $order->modelBrand ? $order->modelBrand->name : '---' ?><br>
                        <?= $order->modelLining ? $order->modelLining->name : '---' ?>
                    </td>
                    <td>
                        <?= $order->modelMaterial ? $order->modelMaterial->name : '---' ?><br>
                        <?= $order->modelColor ? $order->modelColor->name : '---' ?>
                    </td>
                    <td>
                        <?= $order->modelSole ? $order->modelSole->name : '---' ?><br>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5">Данных нет</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
