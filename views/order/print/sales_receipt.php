<?php

use app\helpers\StringCost;

/** @var $model \app\models\Order */

$acceptTime = strtotime($model->accepted);
$issuedTime = strtotime($model->issued);
?>
<!doctype html>
<html>
<head>
    <title>выдача - Товарныи чек база</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { width: 210mm; margin-left: auto; margin-right: auto; border: 1px #efefef solid; font-size: 12pt;}
        p {margin-top: 0.5em; margin-bottom: 1em;}
        table.items{width: 100%; border-collapse: collapse;}
        table.items td, table.items th {padding: 5px;}
        table.items th {white-space: nowrap;}

        .total, .total2{
            margin: 30px 0;
        }
        .total{
            display: flex;
        }
        .total span{
            display: inline-block;
            margin-left: 10px;
            padding-left: 10px;
            flex-grow: 1;
            border-bottom: 1px solid #000;
        }
        .total2{
            display: flex;
        }
        .total2 span{
            display: inline-block;
            border-bottom: 1px solid #000;
        }
        .total2 span:first-child{
            flex-grow: 1;
            margin-right: 10px;
        }
        .total2 span:last-child{
            margin: 0 10px;
            padding: 0 5px;
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
<br><br>
<table width="100%">
    <tbody>
        <tr>
            <td colspan="6"><div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div></td>
        </tr>
        <tr>
            <td colspan="6">
                <div style="text-align:center;" style="width:800px;text-align:left;font-size:10pt;" >
                    <p>(наименование организации, ИНН)</p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6"> </td>
        </tr>
        <tr>
            <td colspan="6">
                <div style="text-align:center;">
                    <p><span style="font-weight: bold; font-size: 13pt; width:100%;">Товарный чек № <?= $model->getFullId(false) ?></span>
                        <span style="font-weight: bold; font-size: 13pt; width:100%;">от __________</span>
                    <p>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table class="items" border="1">
    <tbody>
    <tr>
        <th>
            <p>№<br/>
                п/п
            </p>
        </th>
        <th>
            <p>Наименование, характеристика товара</p>
        </th>
        <th>
            <p>Ед</p>
        </th>
        <th>
            <p>Кол-во</p>
        </th>
        <th>
            <p>Цена</p>
        </th>
        <th>
            <p>Сумма</p>
        </th>
    </tr>
    <tr>
        <td>
            <p><strong>1</strong></p>
        </td>
        <td>
            <p>Сложная ортопедическая обувь с индивидуальными параметрами изготовления</p>
            <p><?= $model->shoes->name ?></p>
            <p>Диагноз: <?= $model->diagnosis->name ?></p>
            <p>№ договора и дата приёма: <?= $model->getFullId(false) ?>, <?= $model->accepted ?></p>
        </td>
        <td>
            <p>пара</p>
        </td>
        <td>
            <p>1</p>
        </td>
        <td>
            <p><?= $model->cost ?></p>
        </td>
        <td>
            <p><?= $model->cost ?></p>
        </td>
    </tr>
    <tr>
        <td colspan="5" rowspan="2">
            <p align="right">Всего</p>
        </td>
        <td rowspan="2">
            <p><?= $model->cost ?></p>
        </td>
    </tr>
 </tbody>
</table>
<?php
    $prepaidText = '---';
    if($model->prepaid) {
        $prepaidText = $model->prepaid.' руб.';
        if($model->prepaid_date) {
            $prepaidText .= ' от '.date('d.m.Y', $model->prepaid_date);
        }
    }
?>
<div class="total">Внесен аванс: <span><?= $prepaidText ?></span></div>
<div class="total">Всего отпущено на сумму: <span><?= $model->cost ?></span></div>
<div class="total2"><span><?= StringCost::num2str($model->cost) ?></span>руб.<span>00</span>коп.</div>
</body>
</html>
<script>
    //window.print();
</script>
