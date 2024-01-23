<?php

use app\helpers\StringCost;

if($new) :
    echo $this->render('form_new', [
        'model' => $model,
    ]);

else :


/** @var $model \app\models\Order */

$acceptTime = strtotime($model->accepted);
$issuedTime = strtotime($model->issued);
?>
<!doctype html>
<html>
<head>
    <title>прием_выдача - бланк заказа1</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { width: 210mm; margin-left: auto; margin-right: auto; border: 1px #efefef solid; font-size: 11pt;}
        p {margin-top: 0.5em; margin-bottom: 1em;}
        p.text {font-size: 11pt;}
        li{margin:10px;}
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
<br>
<span style="font-weight:bold;font-size:18pt;">&nbsp;&nbsp;  МЕДИЦИНСКИЙ ЗАКАЗ № <?= $model->fullId ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:17pt;">Ф/О: <strong><?= $model->payment->nameValue ?></strong></span>
<br>
<table style="width: 100%;">
    <tr>
        <td>
            <ol style="font-size:15pt; padding: 20; margin: 20; width=100">
                <li>Ф.И.О: <strong><?= $model->patient->full_name ?></strong></li>
                <?php if (!empty($model->representative_name)): ?>
                    Ф.И.О представителя: <strong><?= $model->representative_name ?></strong><br>
                <?php endif ?>
                <li>Дата рождения: <?= $model->patient->birthday ?></li>
                <li>Адрес: <?= $model->patient->address ?></li>
                <li>Телефон: <?= $model->patient->phone ?></li>
                <li>Направление №: <?= $model->referral ?></li>
                <li>Вид обуви: <?= $model->shoes->name ?><?= $model->shoes_data ? ' ('.$model->shoes_data.')' : '' ?></li>
                <?php
                    $modelContent = $model->brand ? $model->brand->name : $model->model;
                    if($model->brand_data) $modelContent .= ' ('.$model->brand_data.')';
                ?>
                <li>Модель: <?= $modelContent ?></li>
                <?php
                    $modelColor = $model->color_id ? $model->color_id : $model->color;
                    if($model->color_data) $modelColor .= ' ('.$model->color_data.')';
                ?>
                <li>Цвет: <?= $modelColor ?></li>
                <?php
                    $modelSole = $model->sole_id ? $model->getOptionName('sole_id') : $model->size;
                    if($model->sole_data) $modelSole .= ' ('.$model->sole_data.')';
                ?>
                <li>Подошва/размер: <?= $modelSole ?></li>
                <?php
                    $modelLast = $model->last_id ? $model->getOptionName('last_id') : $model->block;
                    if($model->last_data) $modelLast .= ' ('.$model->last_data.')';
                ?>
                <li>Колодка: <?= $modelLast ?></li>
            </ol>
        </td>
        <td style="vertical-align: top">
            <?= $this->render('//order/print/_barcode', ['model' => $model]) ?>
        </td>
    </tr>
</table>

<p align="center"> <span style="text-decoration: underline; font-size: 15pt; font-weight: bold;">Диагноз и назначения</span></p>
<p><strong style="font-size: 13pt;">Сложная ортопедическая обувь с индивидуальными параметрами изготовлениями. Диагноз: <?= $model->diagnosis->name ?></strong></p>

<p style="font-size:15pt;">
    <?= $model->attributeLabels()['appointment_left'] ?> - <?= $model->appointment_left ?><?= $model->appointment_left_data ? ' ('.$model->appointment_left_data.')' : '' ?>
</p>
<p style="font-size:15pt;">
    <?= $model->attributeLabels()['appointment_right'] ?> - <?= $model->appointment_right ?><?= $model->appointment_right_data ? ' ('.$model->appointment_right_data.')' : '' ?>
</p>
<p style="font-size:15pt;">
    <?//= $model->attributeLabels()['heel_left'] ?> - <?//= $model->heel_left ?><?//= $model->heel_left_data ? ' ('.$model->heel_left_data.')' : '' ?>
</p>
<p style="font-size:15pt;">
    <?//= $model->attributeLabels()['heel_right'] ?> - <?//= $model->heel_right ?><?//= $model->heel_right_data ? ' ('.$model->heel_right_data.')' : '' ?>
</p>

<div><hr></div>
<br/>
<div><hr></div>
<br/>
<br/>
<table width="100%" border="1" >
    <tbody>
    <tr>
        <td align="center">ЛЕВАЯ<p><br><br></p></td>
        <td align="center">ПРАВАЯ<p><br><br></p></td>
    </tr>
    </tbody>
</table>
<br/>
<table width="100%" >
    <tbody>
    <tr >
        <td align="center">
            <p><div style="font-weight: bold; font-size: 16pt; width:100%;">Прием заказа: <br/></div><br>
            «<?= date('d', $acceptTime) ?>» <?= Yii::$app->formatter->asDate($acceptTime, 'MMMM') ?> <?= date('Y', $acceptTime) ?>г.
            </p>

            <p class="text"> Врач: _________________________________<br/><br/>
                (ф.и.о.)_________________________________<br/>
            </p>
            <br><br><br>
            <p class="text">Инженер-протезист : ___________________<br/><br/>
                (ф.и.о.)________________________________<br/>
            </p>

            <p class="text">Заказчик / Представитель:_______________<br/><br/>
                (ф.и.о.) <?= $model->representative_name ? $model->representative_name : $model->patient->full_name ?><br/>
            </p>

        </td>
        <td align="center">
            <p><div style="font-weight: bold; font-size: 16pt; width:100%;">Выдача заказа: <br/></div><br>
            <?php if ($issuedTime > -1): ?>
                «<?= date('d', $issuedTime) ?>» <?= Yii::$app->formatter->asDate($issuedTime, 'MMMM') ?> <?= date('Y', $issuedTime) ?>г.
            <?php else: ?>
                «_____ »________________ 201___г.
            <?php endif ?>
            </p>

            <p class="text"> Врач: _________________________________<br/><br/>
                (ф.и.о.)_________________________________<br/>
            </p>
            <br><br><br>
            <p class="text">Инженер-протезист : ___________________<br/><br/>
                (ф.и.о.)________________________________<br/>
            </p>

            <p class="text">Заказчик / Представитель:_______________<br/><br/>
                (ф.и.о.) <?= $model->representative_name ? $model->representative_name : $model->patient->full_name ?><br/>
            </p>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
<script>
    //window.print();
</script>
<?php endif; ?>
