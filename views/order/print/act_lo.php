<?php

use app\helpers\StringCost;
use app\models\PrintTypes;

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
<table width="100%" style="width: 100%">
    <tr>
        <td colspan="2">
            <div style="text-align:center;font-size: 15pt;">
                <strong>Акт выполненных работ</strong>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div style="text-align:center;font-size: 15pt;margin-top: 20px;">
                г. Санкт-Петербург
            </div>
        </td>
        <td>
            <div style="text-align:right;font-size: 15pt;margin-top: 20px;">
                «_____»  ______________ 20__ года
            </div>
        </td>
    </tr>
</table>
<br/>
<div class="block">
    Общество с ограниченной ответственностью «ОртоДом», именуемый в дальнейшем "Исполнитель", в лице генерального директора Акопяна Артура Аликовича, действующего на основании Устава, с одной стороны, и <?= $model->representative_name ? $model->representative_name : $model->patient->full_name ?>, именуемый(ая) в дальнейшем «Заказчик», паспорт <?= $model->patient->passport_data ?>
    <?php if($model->representative_name) : ?>
           , действующий в интересах несовершеннолетнего <?= $model->patient->full_name ?>, <?= $model->patient->birthday ?> г.р., зарегистрированного по адресу: <?= $model->patient->address ?>
    <?php endif; ?>
    с другой стороны, вместе именуемые "Стороны, составили настоящий акт о нижеследующем:
</div>
<div class="block">
    <p>
        1. Стороны подтверждают, что в соответствии с договором № <?= $model->getFullId(false) ?> от <?= $model->accepted ?> г. Исполнитель выполнил следующие работы Заказчику, а именно изготовил сложную ортопедическую обувь по индивидуальным параметрам изготовления:
    </p>
    <table class="table">
        <tr>
            <th>ФИО несовершеннолетнего</th>
            <th>Вид сложной ортопедической обуви</th>
            <th>Кол-во пар</th>
            <th>Цена за 1 пару (руб.)</th>
            <th>Сумма (руб.)</th>
        </tr>
        <tr>
            <td><?= $model->patient->full_name ?></td>
            <td><?= $model->shoes->name ?></td>
            <td>1</td>
            <td><?//= $model->cost ?><?= (isset($defaultPrice) && $defaultPrice) ? number_format($defaultPrice, 2, '.', ' ') : number_format(PrintTypes::PRICE_LO, 2, '.', ' ') ?></td>
            <td><?//= $model->cost ?><?= (isset($defaultPrice) && $defaultPrice) ? number_format($defaultPrice, 2, '.', ' ') : number_format(PrintTypes::PRICE_LO, 2, '.', ' ') ?></td>
        </tr>
    </table>
    <p>
        2. Работы выполнены и оказаны в срок, установленный договором.
    </p>
    <p>
        3. Претензий по качеству выполненных работ у Заказчика нет.
    </p>
    <p>
        4. Акт составлен в трех экземплярах, имеющих равную юридическую силу, по одному для каждой из Сторон и один для уполномоченного органа, осуществляющего выплаты по сертификату.
    </p>
</div>
<div class="block">
    <table>
        <tr>
            <td width="50%">
                <p><em><strong>ИСПОЛНИТЕЛЬ:</strong></em></p>
                <p>ООО «ОртоДом»<br>
                    Юридический и фактический адрес юридический адрес -198097, г. Санкт-Петербург, Цветочная ул., д.6, лит.Д, 4 этаж, пом.1Н (№№113, 114, 115)<br>
                    ИНН 7814494217 КПП 781001001<br>
                    ОГРН 1117847085630<br>
                    Тел. (812) 934-4554<br>
                    <a href="mailto:shoes@list.ru">shoes@list.ru</a></p>
                <div> _____________ (Акопян А.А.)</div>
            </td>
            <td width="50%">
                <p><em><strong>ЗАКАЗЧИК/ПРЕДСТАВИТЕЛЬ:</strong></em> </p>
                <p>Ф.И.О. <?= $model->representative_name ? $model->representative_name : $model->patient->full_name ?><br>
                    Зарегистрирован: <?= $model->patient->address ?><br>
                    Паспортные данные <?= $model->patient->passport_data ?><br>
                    Тел. <?= $model->patient->phone ?></p>
                <br>
                <div> _____________ (<?= $model->representative_name ? $model->representative_name : $model->patient->full_name ?>)</div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
<style>
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 10px;
        border: 1px solid #000;
        vertical-align: top;
    }
    .block {
        padding: 10px 0;
    }
</style>
