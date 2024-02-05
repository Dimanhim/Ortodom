<?php

use app\helpers\StringCost;

/** @var $model \app\models\Order */

$acceptTime = strtotime($model->accepted);
?>
<!doctype html>
<html>
<head>
    <title>	Акт выполненных работ</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { width: 210mm; margin-left: auto; margin-right: auto; border: 1px #efefef solid; font-size: 13pt;}
        p {margin-top: 0.5em; margin-bottom: 1em;}
    </style>
</head>
<body>
<table width="100%">
    <tr>
        <td colspan="2">
            <div style="text-align:center;font-size: 15pt;">
                <strong>Акт выполненных работ № <span style="font-weight:bold;"><?= $model->getFullId(false) ?> </span> от _________</strong>
            </div>
        </td>
    <tr>
        <td colspan="2">
            <br/>
            <div style="text-align:center;">
                (на изготовление индивидуальных ортопедических изделий)
            </div>
        </td>
    </tr>
</table>
<br/>
<div>Исполнитель:</div>
<div style="font-weight: bold; font-size: 13pt;">
    ООО «ОртоДом» в лице Генерального директора Акопяна Артура Аликовича
</div>
<br/>

<div>Заказчик:</div>
<div style="font-weight: bold; font-size: 13pt; width:100%;">
    (Ф.И.О.) <span style=""><?= $model->patient->full_name ?></span>
</div>
<?php if (!empty($model->representative_name)): ?>
    <div style="font-weight: bold; font-size: 13pt; width:100%;">
        (Ф.И.О. представителя) <span style=""><?= $model->representative_name ?></span>
    </div>
<?php endif ?>
<br/>

<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>

<p>Услуги по&nbsp;изготовлению Изделия: <span style="font-weight: bold; font-size: 13pt; width:100%;">Сложная ортопедическая обувь с индивидуальными параметрами изготовлениями: <?= $model->shoes->name ?>. Диагноз: <?= $model->diagnosis->name ?></span></p>
<p>В&nbsp;количестве <span style="text-decoration: underline; font-weight: bold;">1 пара</span> выполнены в&nbsp;срок.</p>
<p>
    Стоимость Изделия составляет <?= intval($model->cost) ?> руб. <?= str_pad(intval($model->cost * 100) % 100, 2, 0, STR_PAD_LEFT) ?> коп.
    (<?= StringCost::num2str($model->cost) ?>)
</p>

<div style="width:800px;text-align:left;font-size:11pt;">Вышеперечисленные работы (услуги) выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам оказания услуг претензий не имеет.</div>
<div>
    <br />
    <div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
    <p><em><strong>ИСПОЛНИТЕЛЬ:</strong></em></p>
    <p>ООО «ОртоДом»<br>
        Юридический и фактический адрес юридический адрес -198097, г. Санкт-Петербург, Цветочная ул., д.6, лит.Д, 4 этаж, пом.1Н (№№113, 114, 115)<br>
        ИНН 7814494217 КПП 781001001<br>
        ОГРН 1117847085630<br>
        Тел. (812) 934-4554<br>
        <a href="mailto:shoes@list.ru">shoes@list.ru</a></p>
    <div> ______________________ (Акопян А.А.)</div>
    <br>
    <p><em><strong>ЗАКАЗЧИК/ПРЕДСТАВИТЕЛЬ:</strong></em> </p>
    <p>Ф.И.О. <?= $model->representative_name ? $model->representative_name : $model->patient->full_name ?><br>
        Зарегистрирован: <?= $model->patient->address ?><br>
        Паспортные данные <?= $model->patient->passport_data ?><br>
        Тел. <?= $model->patient->phone ?></p>
    <br>
    <div> ______________________ (<?= $model->representative_name ? $model->representative_name : $model->patient->full_name ?>)</div>
    <br>
</body>
</html>
<script>
    //window.print();
</script>
