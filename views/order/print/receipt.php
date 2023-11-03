<?php

use app\helpers\StringCost;

/** @var $model \app\models\Order */
$user = Yii::$app->user->identity;
$acceptTime = strtotime($model->accepted);
?>
<!doctype html>
<html>
<head>
    <title>прием - квит о приеме база</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body {
            width: 210mm;
            margin-left: auto;
            margin-right: auto;
            border: 1px #efefef solid;
            font-size: 14pt;
            line-height: 1.1;
        }
        p {
            margin-top: 0.2em;
            margin-bottom: 0.3em;
        }
        .pr-header {
            text-decoration: underline;
            font-weight: bold;
            font-size: 16pt;
        }
        .pr-note {
            padding: 15px 20px;
            border: 1px solid #d43f3a;
            color: #d43f3a;
        }
    </style>
</head>

<body>
<table width="100%">
    <tbody>
    <tr>
        <td><img src="/images/ortodom.png" width="317" height="120"></td>
        <td>
            <div style="text-align:right;">
                <p>«ОртоДом»<br/>
                    Тел +7 (812) 934-4554, Факс +7 (812) 388 17 10<br/>
                    ИНН/КПП 7814494217/781001001<br/>
                    Aдрес 196084, г. Санкт-Петербург,<br/>
                    ул. Цветочная, д.6, лит. Д 4 этаж, пом.1Н<br/>
                    Email <a href="mailto:shoes@list.ru">shoes@list.ru</a></p>
            </div>
        </td>
    </tr>
    </tbody>
</table>

<p class="pr-header"><span>КВИТАНЦИЯ О ПРИЁМЕ ЗАКАЗА НА ИЗГОТОВЛЕНИЕ ОРТОПЕДИЧЕСКОЙ ОБУВИ</span></p>
<br><span style="font-weight: bold; width:100%;">ЗАКАЗ №<?= $model->fullId ?></span>
<p>Форма оплаты: <strong><?= $model->payment->nameValue ?></strong></p>
<p>Ф.И.О: <strong><?= $model->patient->full_name ?></strong></p>
<?php if (!empty($model->representative_name)): ?>
    <p>Ф.И.О представителя: <strong><?= $model->representative_name ?></strong></p>
<?php endif ?>
<p>Направление № <?= $model->referral ?> </p>
<p>Вид обуви: <strong>сложная ортопедическая обувь с индивидуальными параметрами изготовления <?= $model->shoes->name ?></strong></p>
<?php
    $modelContent = $model->brand ? $model->brand->name : $model->model;
    if($model->brand_data) $modelContent .= ' ('.$model->brand_data.')';
?>
<p>Модель: <strong><?= $modelContent ?></strong> </p>
<?php
    $modelColor = $model->color_id ? $model->color_id : $model->color;
    if($model->color_data) $modelColor .= ' ('.$model->color_data.')';
?>
<p>Цвет: <strong><?= $modelColor ?></strong> </p>
<?php
$modelLining = $model->modelLining ? $model->modelLining->name : '';
if($model->lining_data) $modelLining .= ' ('.$model->lining_data.')';
?>
<p>Подкладка: <strong><?= $modelLining ?></strong> </p>
<?php
    $modelSole = $model->modelSole ? $model->modelSole->name : $model->size;
    if($model->sole_data) $modelSole .= ' ('.$model->sole_data.')';
?>
<p style="margin-bottom: 2em;">Подошва/размер: <strong><?= $modelSole ?></strong> </p>

<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>

<div style="text-align:left;">
    <p><span style="text-decoration: underline; font-weight: bold; ">Пункты приема заказов на изготовление ортопедической обуви:</span></p>
    <p>г. Санкт-Петербург, Выборгское шоссе 5<br/>
        График работы: Пн-Сб - с 10:00 до 20:00; перерыв с 14:00 до 15:00; Вс - Выходной<br/>
        Тел:(812) 947-7307</p>
</div>

<div style="text-align:left; font-weight: bold; font-size: 13pt; width:100%;">
    Единый справочный телефон : 934-4554
</div>

<br>

<table width="100%">
    <tbody>
    <tr>
        <td><div style="text-align:left;">
                <p><span style="font-weight: bold;">Прием заказа:</span> дата «<?= date('d', $acceptTime) ?>» <?= Yii::$app->formatter->asDate($acceptTime, 'MMMM') ?> <?= date('Y', $acceptTime) ?>г.<br/>
                    <br><br><br>
                    <?php if($user->name) : ?>
                    Инженер-протезист  ____________<?= $user->name ?>
                    <?php else : ?>
                    Инженер-протезист  ____________(ф.и.о.) ______________
                    <?php endif; ?>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="pr-note">
                После того, как Ваш заказ будет готов, Вы получите СМС и звонок от компании OrtoDom
            </div>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>

<script>
    //window.print();
</script>
