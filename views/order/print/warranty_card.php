<?php

use app\helpers\StringCost;

/** @var $model \app\models\Order */

$acceptTime = strtotime($model->accepted);
$issuedTime = strtotime($model->issued);

?><!doctype html>
<html>
<head>
    <title>Гарантийный талон 2017 база</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { width: 210mm; margin-left: auto; margin-right: auto; border: 1px #efefef solid; font-size: 13pt;}
        p {margin-top: 0.5em; margin-bottom: 1em;}
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


<div  style="font-weight: bold; font-size: 14pt;">ГАРАНТИЙНЫЙ ТАЛОН</div>
<br>

<p><strong>Заказ № <?= $model->getFullId(false) ?></strong><br>
    Ф.И.О <strong><?= $model->patient->full_name ?></strong><br>
    Вид обуви / артикул: <strong>сложная ортопедическая обувь с индивидуальными параметрами изготовления <?= $model->shoes->name ?></strong><br>
    <?php
        $modelContent = $model->brand ? $model->brand->name : $model->model;
        if($model->brand_data) $modelContent .= ' ('.$model->brand_data.')';
        $modelColor = $model->color_id ? $model->color_id : $model->color;
        if($model->color_data) $modelColor .= ' ('.$model->color_data.')';
        $modelSole = $model->modelSole ? $model->modelSole->name : $model->size;
        if($model->sole_data) $modelSole .= ' ('.$model->sole_data.')';
    ?>
    Модель: <strong><?= $modelContent ?></strong><br>
    Цвет: <strong><?= $modelColor ?></strong><br>
    Подошва/размер: <strong><?= $modelSole ?></strong><br>
    Заказ выдан _____________________________<br>
    Выдал ___________________________________________________________<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    (подпись)
</p>

<br><br><br><br><br><br>

<p><span style="font-weight: bold; font-size: 14pt; width:100%;">Адреса пункта приёма и график работы:</span></p>
<p>1)СПб., Выборгское шоссе, дом 5 (ст. метро Озерки), <br>
    <!--График работы: Пн-Пт - с 10:00 до 19:00; Сб-Вс - Выходной<br>-->
    График работы: Пн-Сб - с 10:00 до 20:00; перерыв с 14:00 до 15:00; Вс - Выходной<br>
    тел.(812)947-7307, (812)934-4554
</p>

<br>
<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>


<p>Гарантийный срок и срок службы сложной ортопедической обуви составляет 6 месяцев, для детей-инвалидов – 3 месяца.<br></p>
<p>В случае выявления дефектов обращаться по всем вопросам их устранения по адресу или телефону: г. Санкт-Петербург ,ул. Цветочная дом 6, 13 оф. (812)934-4554 , (812)388-1710 при предъявлении паспорта, квитанции или кассового чека .<br></p>
<p>Потребитель не вправе отказаться от товара надлежащего качества, имеющего индивидуально-определенные свойства, если указанный товар может быть использован исключительно приобретающим (получающим) его потребителем (Федеральный закон РФ "О защите прав потребителей" от 07.02.1992 N 2300-1).<br></p>
<p>Во избежание возможных недоразумений, настоятельно рекомендуем Вам ознакомиться с руководством по эксплуатации изделия.</p>



</body>
</html>

<script>
    //window.print();
</script>
