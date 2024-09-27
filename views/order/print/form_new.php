<?php

use app\helpers\StringCost;

/** @var $model \app\models\Order */

$acceptTime = strtotime($model->accepted);
$issuedTime = strtotime($model->issued);

$user = Yii::$app->user->identity;
?>
<!doctype html>
<html>
<head>
    <title>прием_выдача - бланк заказа1</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { width: 210mm; margin-left: auto; margin-right: auto; border: 1px #efefef solid; font-size: 11pt;}
        p {margin-top: 0.5em; margin-bottom: 0.5em;}
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

<span style="font-weight:bold;font-size:18pt;">&nbsp;&nbsp;  МЕДИЦИНСКИЙ ЗАКАЗ № <?= $model->getFullId() ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:17pt;">Ф/О: <strong><?= $model->payment->nameValue ?></strong></span>
<br>
<table style="width: 100%">
    <tr>
        <td>
            <ol class="form-list">
                <li>
                    Ф.И.О:
                    <span>
                        <strong>
                            <?= $model->patient->full_name ?>
                        </strong>
                    </span>
                </li>
                <?php if (!empty($model->representativeName)): ?>
                    Ф.И.О представителя:
                    <span class="dop-data">
                        <?= $model->representativeName ?>
                    </span>
                    <br>
                <?php endif ?>
                <li>
                    Дата рождения:
                    <span><?= $model->patient->birthday ?></span>
                </li>
                <li>
                    Адрес:
                    <span><?= $model->patient->address ?></span>
                </li>
                <li>
                    Телефон:
                    <span class="form-phone-text"><?= $model->patient->phone ?></span>
                </li>
                <li>
                    Направление №:
                    <span><?= $model->referral ?></span>
                </li>
                <li>
                    Вид обуви:
                    <span class="dop-data">
                        <?= $model->shoes->name ?>
                    </span>
                    <?= $model->shoes_data ? ' <span class="dop-data">('.$model->shoes_data.')</span>' : '' ?>
                </li>
                <?php
                    $modelContent = $model->brand ? $model->brand->name : $model->model;
                    if($model->brand_data) $modelContent .= ' <span>('.$model->brand_data.')</span>';
                ?>
                <li>
                    Модель:
                    <span class="dop-data"><?= $modelContent ?></span>
                </li>
                <?php
                    $lining = $model->modelLining ? $model->modelLining->name : false;
                    if($model->lining_data) $lining .= ' <span>('.$model->lining_data.')</span>';
                ?>
                <li>
                    Подкладка:
                    <span class="dop-data"><?= $lining ?></span>
                </li>
                <?php
                    $material = $model->modelMaterial ? $model->modelMaterial->name : false;
                    if($model->material_data) $material .= ' <span>('.$model->material_data.')</span>';
                ?>
                <li>
                    Верх обуви:
                    <span class="dop-data"><?= $material ?></span>
                </li>
                <?php
                    $modelColor = $model->color_id ? $model->color_id : $model->color;
                    if($model->color_data) $modelColor .= ' <span>('.$model->color_data.')</span>';
                ?>
                <li>
                    Цвет:
                    <span class="dop-data"><?= $modelColor ?></span><br>
                    <span class="li-tip-text">Оттенок цвета кожи может отличаться в зависимости от партии</span>
                </li>
                <?php
                    $modelSole = $model->modelSole ? $model->modelSole->name : $model->size;
                    if($model->sole_data) $modelSole .= ' <span>('.$model->sole_data.')</span>';
                    //$modelSole = $model->sole_id ? $model->getOptionName('sole_id') : $model->size;
                    //if($model->sole_data) $modelSole .= ' ('.$model->sole_data.')';
                ?>
                <li>
                    Подошва/размер:
                    <span class="dop-data"><?= $modelSole ?></span><br>
                    <span class="li-tip-text">Вид подошвы может быть изменен, в зависимости от параметров стопы</span>
                </li>
                <?php
                    $modelLast = $model->last_id ? $model->getOptionName('last_id') : $model->block;
                    if($model->last_data) $modelLast .= ' <span>('.$model->last_data.')</span>';
                ?>
                <li>
                    Колодка:
                    <span class="dop-data"><?= $modelLast ?></span>
                </li>
            </ol>
        </td>
        <td style="vertical-align: top">
            <?= $this->render('//order/print/_barcode', ['model' => $model]) ?>
            <?= $model->fittingSign() ?>
            <div style="width: 270px">
                <?= \yii\helpers\Html::img($model->modelImage(), ['style' => 'width: 100%']) ?>
            </div>
        </td>
    </tr>
</table>

<p>
    <span style="font-size: 15pt; font-weight: bold;">
        Диагноз и назначения: <?= $model->diagnosis->name ?>
    </span>
</p>
<div style="padding: 5px 0"><hr></div>
<br/>
<table width="100%" border="1">
    <tbody>
        <tr>
            <td style="padding: 5px;font-size: 15pt; font-weight: bold;">
                <p>Назначение: левая</p>
                <p class="appointments-text">
                    <?= $model->appointmentLeft ? $model->appointmentLeft->name : '' ?>
                    <?= $model->appointment_left_data ? ' ('.$model->appointment_left_data.')' : '' ?>
                </p>
            </td>
            <td style="padding: 5px;font-size: 15pt; font-weight: bold;">
                <p>Назначение: правая</p>
                <p class="appointments-text">
                    <?= $model->appointmentRight ? $model->appointmentRight->name : '' ?>
                    <?= $model->appointment_right_data ? ' ('.$model->appointment_right_data.')' : '' ?>
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px; border-top: 1px solid #ccc; height: 20px">

            </td>
            <td style="padding: 5px; border-top: 1px solid #ccc; height: 20px">

            </td>
        </tr>
    </tbody>
</table>

<table width="100%" >
    <tbody>
    <tr >


        <?php if($user->shortName) : ?>
        <td align="center">
            <p><div style="font-weight: bold; font-size: 16pt; width:100%;padding-bottom: 5px;">Прием заказа: <br/></div>
            «<?= date('d', $acceptTime) ?>» <?= Yii::$app->formatter->asDate($acceptTime, 'MMMM') ?> <?= date('Y', $acceptTime) ?>г.
            </p>

            <p class="text" style=""> Врач / Инженер-протезист : ______________<br/>
                <!--<br/>(ф.и.о.)_________________________________<br/>-->
            </p>
            <p class="text" style="text-align: left; padding-left: 56px;">
                <?= $user->name ?>
            </p>

            <p class="text">Заказчик / Представитель:_______________<br/><br/>
                (ф.и.о.) <?= $model->fullName ?><br/>
            </p>


        </td>

        <?php else : ?>




        <td align="center">
            <p><div style="font-weight: bold; font-size: 16pt; width:100%;padding-bottom: 5px;">Прием заказа: <br/></div>
            «<?= date('d', $acceptTime) ?>» <?= Yii::$app->formatter->asDate($acceptTime, 'MMMM') ?> <?= date('Y', $acceptTime) ?>г.
            </p>

            <p class="text"> Врач: _________________________________<br/>
                <!--<br/>(ф.и.о.)_________________________________<br/>-->
            </p>
            <p class="text">Инженер-протезист : ___________________<br/>
                <!--<br/>(ф.и.о.)________________________________<br/>-->
            </p>

            <p class="text">Заказчик / Представитель:_______________<br/><br/>
                (ф.и.о.) <?= $model->fullName ?><br/>
            </p>

        </td>
        <?php endif; ?>





        <td align="center">
            <p><div style="font-weight: bold; font-size: 16pt; width:100%;padding-bottom: 5px;">Выдача заказа: <br/></div>
            <?php if ($issuedTime > -1): ?>
                «<?= date('d', $issuedTime) ?>» <?= Yii::$app->formatter->asDate($issuedTime, 'MMMM') ?> <?= date('Y', $issuedTime) ?>г.
            <?php else: ?>
                «_____ »________________ 201___г.
            <?php endif ?>
            </p>

            <p class="text"> Врач: _________________________________<br/>
                <!--<br/>(ф.и.о.)_________________________________<br/>-->
            </p>

            <p class="text">Инженер-протезист : ___________________<br/>
                <!--<br/>(ф.и.о.)________________________________<br/>-->
            </p>

            <p class="text">Заказчик / Представитель:_______________<br/><br/>
                (ф.и.о.) <?= $model->fullName ?><br/>
            </p>
        </td>
    </tr>
    </tbody>
</table>
<style>
    .form-list {
        font-size:14pt; 
        line-height: 14pt;
    }
    .form-list span.dop-data
    /*.form-list span, .appointments-text*/
    {
        color: #337ab7;
        font-weight: bold;
    }
    .form-list span.form-phone-text, .appointments-text {
        color: #d9534f;
        font-weight: bold
    }
    .li-tip-text {
        font-size: 10pt;
        line-height: 10pt;
    }
</style>
</body>
</html>
<script>
    //window.print();
</script>
