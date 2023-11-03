<?php

use yii\helpers\Html;

$this->title = 'Наряд затяжка';
$countRows = 7;

$rowWidth = 100 / $countRows;
$count = 1;
?>
<div class="outfit-container">
    <h2><?= Html::encode($this->title) ?></h2>
    <table class="table table-bordered table-outfit">
        <tr>
            <th></th>
            <th>№</th>
            <th>Колодка и размер</th>
            <th>Модель</th>
            <th>Подкладка</th>
            <th>Верх</th>
            <th>Цвет</th>
            <th>Подошва</th>
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
                    <td class="size-row">

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
                    <td class="sole-row">
                        <?= $order->modelSole ? $order->modelSole->name : '---' ?><br>
                    </td>
                </tr>
            <?php $count++; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Данных нет</td>
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
        width: <?= $rowWidth * 0.5 ?>%;
        /*width: 11.1111%;*/
    }
    table tr td.number {
        width: <?= $rowWidth * 0.25 ?>%;
    }
    table tr td.size-row {
        width: <?= $rowWidth * 2 ?>%;
        /*width: 26.6667%;*/
    }
    table tr td.color-row {
        width: <?= $rowWidth * 1.25 ?>%;
        /*width: 17.7778%;*/
    }
    table tr td.sole-row {
        width: <?= $rowWidth * 1.5 ?>%;
        /*width: 17.7778%;*/
    }
</style>
