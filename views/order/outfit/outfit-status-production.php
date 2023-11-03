<?php

use yii\helpers\Html;

$this->title = 'Наряд производство';

?>

<div class="outfit-container">
    <h2><?= Html::encode($this->title) ?></h2>
    <table class="table table-bordered table-outfit">
        <tr>
            <th>№ Заказа</th>
            <th>ФИО</th>
            <th>Модель</th>
            <th>Подкладка</th>
            <th>Дата приема</th>
        </tr>
        <?php if($orders) : ?>
            <?php foreach($orders as $order) : ?>
                <tr>
                    <td>
                        <?= $order->id ?>
                    </td>
                    <td>
                        <?= $order->patient ? $order->patient->full_name : '---' ?>
                    </td>
                    <td>
                        <?= $order->modelName ?>
                    </td>
                    <td>
                        <?= $order->modelLining ? $order->modelLining->name : '---' ?>
                    </td>
                    <td>
                        <?= $order->accepted ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5">Данных нет</td>
            </tr>
        <?php endif; ?>
    </table>
    <?//= $this->render('operation-list', ['orders' => $orders]) ?>
</div>
<style>
    h2 {
        margin-top: 0;
    }
    table tr td {
        width: 10%;
    }
</style>

