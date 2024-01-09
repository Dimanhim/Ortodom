<?php

use yii\helpers\Html;

$this->title = 'Накладная (готовы к отправке)';
$count = 1;
?>
<div class="outfit-container">
    <div class="row">
        <div class="col-md-6">
            <h2 style="white-space: nowrap"><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <?= date('d.m.Y') ?>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-outfit table-cm">
        <tr>
            <th class="cm-1-5">№ п/п</th>
            <th class="cm-9-0">ФИО</th>
            <th class="cm-7-5">ШК</th>
        </tr>
        <?php if($orders) : ?>
            <?php foreach($orders as $order) : ?>
                <tr>
                    <td>
                        <?= $count ?>
                    </td>
                    <td>
                        <div>
                            <?= $order->patient ? $order->patient->full_name : '---' ?>
                        </div>
                        <div>
                            <strong><?= $order->id ?></strong>
                        </div>

                    </td>
                    <td>
                        <?= $order->getBarcodeView() ?>
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
    <?//= $this->render('operation-list', ['orders' => $orders]) ?>
</div>
<style>
    h2 {
        margin-top: 0;
    }
    .cm-1-5 {
        min-width: 1.5cm;
        max-width: 1.5cm;
        width: 1.5cm;
    }
    .cm-7-5 {
        min-width: 7.5cm;
        max-width: 7.5cm;
        width: 7.5cm;
    }
    .cm-9-0 {
        min-width: 9.0cm;
        max-width: 9.0cm;
        width: 9.0cm;
    }
    .table-cm {
        /*width: 18cm !important;*/
    }
</style>
