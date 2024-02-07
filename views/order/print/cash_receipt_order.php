<?php

use app\helpers\StringCost;

/** @var $model \app\models\Order */

$acceptTime = strtotime($model->accepted);
?>
<!doctype html>
<html>
<head>
    <title>выдача - Товарныи чек база</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { width: 210mm; margin-left: auto; margin-right: auto; border: 1px #efefef solid; font-size: 12pt;}
        p {margin-top: 0.5em; margin-bottom: 1em;}
    </style>
</head>

<body>
<table>
    <tbody>
    <tr style="height: 1px;">
        <td colspan="6">
            <div style="text-align:right;">Унифицированная форма № КО-1<br/>
                Утверждена постановлением Госкомстата<br/>
                России от 18.08.98 г. № 88<br/>
            </div>
        </td>

        <td rowspan="18">
            <table border="1px" width="1px" height="450px"></table>
            <div class="vertical-text">линия отреза</div>
            <table border="1px" width="1px" height="450px"></table>
        </td>
        <td colspan="4">
            <div style="font-weight:bold;font-size:13pt; text-align:center;">ООО «ОртоДом»</span>
            </div>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td colspan="4"><br/>
            <table width="100%" >
                <caption></caption>
                <tbody>
                <tr>
                    <td>

                        <div style="background-color:#000000; width:100%; font-size:1px; height:1px; text-align:center; "></div>
                        <div style="text-align:center;">организация</div>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="background-color:#000000; width:100%; font-size:1px; height:1px; text-align:center;"></div>
                        <div style="text-align:center;">структурное подразделение</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
        </td>
        <td>
            <table>
                <caption></caption>
                <tbody>
                <tr>
                    <td><br/>
                    </td>
                </tr>
                <tr>
                    <td>Форма по ОКУД</td>
                </tr>
                <tr>
                    <td>по ОКПО</td>
                </tr>
                <tr>
                    <td><br/>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        <td>
            <table width="100%" border="1">
                <caption></caption>
                <tbody>
                <tr>
                    <td>Код<br/>
                    </td>
                </tr>
                <tr>
                    <td>0310001</td>
                </tr>
                <tr>
                    <td><br/>
                    </td>
                </tr>
                <tr>
                    <td><br/>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        <td colspan="4">
            <div style="text-align:center;"> КВИТАНЦИЯ  </div><br/>
            </strong>к приходному кассовому ордеру №<?= $model->getFullId(false) ?><br/>
            от «<?= date('d', time()) ?>» <?= Yii::$app->formatter->asDate(time(), 'MMMM') ?> <?= date('Y', time()) ?><br/>
            Принято от: <?= $model->fullName ?><br>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td colspan="4">
            <div  style="font-weight: bold; font-size: 12pt; text-align:center; ">ПРИХОДНЫЙ КАССОВЫЙ ОРДЕР</div>
        </td>
        <td> </td>
        <td>
            <table border="1">
                <caption></caption>
                <tbody>
                <tr>
                    <td>Номер документа</td>
                    <td>Дата составления</td>
                </tr>
                <tr>
                    <td>
                        <?= $model->getFullId(false) ?>
                    </td>
                    <td>
                        <?= date('d.m.Y') ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
        </td>
        <td colspan="4">
            <p style="margin-bottom: 0;">Основание:<br/>
            <span style="text-decoration: underline; font-weight: bold;"> Залоговая стоимость За изготовление сложной Ортопедической обуви с индивидуальными параметрами изготовления</span></p>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td colspan="6">
            <table border="1"; width="100%" >
                <caption></caption>
                <tbody>
                <tr>
                    <td rowspan="2">Дебет </td>
                    <td colspan="3"><div style="text-align:center;"> Кредит </div>
                    </td>
                    <td rowspan="2">Сумма, <br/>
                        руб, коп <br/>
                    </td>
                    <td rowspan="2">Код целевого <br/>
                        назначения <br/>
                    </td>
                </tr>
                <tr>
                    <td>код струк-<br/>
                        турного под-<br/>
                        разделения
                    </td>
                    <td>корреспонди-<br/>
                        рующий счет,<br/>
                        субсчет
                    </td>
                    <td>корреспонди-<br/>
                        рующий счет,<br/>
                        субсчет
                    </td>
                </tr>
                <tr>
                    <td><br/>
                    </td>
                    <td><br/>
                    </td>
                    <td><br/>
                    </td>
                    <td><br/>
                    </td>
                    <td><br/>
                    </td>
                    <td><br/>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
        </td>
        <td colspan="3">
            <p>Общ. сумма - <?= $model->cost ?></p>
            <p>Аванс - <?= $model->prepaid ?></p>
        </td>
        <td><br/>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td>Принято от:</td>
        <td colspan="5">
            <?= $model->fullName ?>
        </td>
        <td>___________</td>
        <td>руб._______</td>
        <td><br/>
        </td>
        <td>коп.<br/></td>
    </tr>
    <tr style="height: 1px;">
        <td>Основание:</td>
        <td colspan="5">
            <p><span style="text-decoration: underline; font-weight: bold;">Залоговая стоимость за изготовление сложной Ортопедической обуви с индивидуальными параметрами изготовления</span></p>
        </td>
        <td colspan="4">
            <p>В том числе:<br/>
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            </p>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td>Аванс:</td>
        <td colspan="5">
            <p><?= StringCost::num2str($model->prepaid) ?></p>
        </td>
        <td colspan="4"></td>
    </tr>
    <tr style="height: 1px;">
        <td>Сумма:</td>
        <td colspan="5">
            <p><?= StringCost::num2str($model->cost) ?></p>
        </td>
        <td colspan="4">
            <p>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ___________ г.</p>
            <div style="text-align:left;font-size:10pt;">М.П.(штампа)</div>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td>В том числе:</td>
        <td colspan="5">
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <br/>
        </td>
        <td> </td>
        <td><br/>
        </td>
        <td><br/>
        </td>
        <td><br/>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td>Приложение:</td>
        <td colspan="5">
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <br/>
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
        </td>
        <td>Главный бухгалтер</td>
        <td colspan="3">
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <div style="text-align:center;font-size:10pt;">подпись</div>
        </td>
    </tr>
    <tr style="height: 1px;">
        <td>Главный бухгалтер</td>
        <td colspan="2">
            <br/>
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <div style="text-align:center;font-size:10pt;">подпись</div>
        </td>
        <td>
        </td>
        <td colspan="2">
            <br/>
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <div style="text-align:center;font-size:10pt;">расшифровка подписи </div>
        </td>

        <td colspan="3">
            Кассир_____________________<br><div style="text-align:center;font-size:10pt;">подпись</div>

        </td>


    </tr>

    <tr style="height: 1px;">
        <td>
            Получил кассир</td>
        <td colspan="2"><br/>
        </td>
        <td><br/>
        </td>

        <td colspan="2">
            <div style="text-align:center;"></div>
        </td>

        <td colspan="4">
            <div style="text-align:center;"></div>
        </td>
    </tr>

    <tr style="height: 1px;">
        <td> </td>
        <td colspan="2">
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <div style="text-align:center;font-size:10pt;">подпись </div>
        </td>
        <td> </td>
        <td colspan="2">
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <div style="text-align:center;font-size:10pt;">расшифровка подписи</div>
        </td>
        <td colspan="4">
            <div style="background-color:#000000; width:100%; font-size:1px; height:1px;">&nbsp;</div>
            <div style="text-align:center;font-size:10pt;">расшифровка подписи</div>
        </td>
        <td><br/>
        </td>
    </tr>


    </tbody>
</table>


</body>
</html>
<script>
   // window.print();
</script>
