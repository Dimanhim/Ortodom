<table class="operation-list-table">
    <tr>
        <td class="td-1 null"></td>
        <td class="td-2 null"></td>
        <td class="td-3 null"></td>
        <td class="td-4 null"></td>
        <td class="td-5 null"></td>
        <td class="td-6 null"></td>
    </tr>
    <tr>
        <td colspan="4" class="bb br fs16">
            <b>ОПЕРАЦИОННЫЙ ЛИСТ ЗАКАЗА</b>
        </td>
        <td colspan="2" class="td-5-6 bb fs16">
            <?= $order->id ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="short"></td>
    </tr>
    <tr>
        <td colspan="4" class="" style="position: relative;">
            <div class="operation-fio fs16">
                <?= $order->patient ? $order->patient->full_name : '' ?>
            </div>
        </td>
        <td class="td-5 bt bl">

        </td>
        <td class="td-6 bt bl">

        </td>
    </tr>
    <tr>
        <td colspan="4">

        </td>
        <td class="td-5 bt bl">

        </td>
        <td class="td-6 bt bl">

        </td>
    </tr>
    <tr>
        <td class="td-1 bt br">
            Модель
        </td>
        <td colspan="2" class="bt br">
            <?= $order->getModelContent() ?>
        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bt bb bl">

        </td>
        <td class="td-6 bt bb bl">

        </td>
    </tr>
    <tr>
        <td class="td-1 bt br">
            Подкладка
        </td>
        <td colspan="2" class="bt br">
            <?= $order->getLiningContent() ?>
        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bt bl">

        </td>
        <td class="td-5 bt bl">

        </td>
    </tr>
    <tr>
        <td class="td-1 bt br">
            Верх обуви
        </td>
        <td colspan="2" class="bt br">
            <?= $order->getMaterialContent() ?>
        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bt bl bb" style="position: relative">

        </td>
        <td class="td-6 bt bb bl">

        </td>
    </tr>
    <tr>
        <td class="td-1 bt bb br">
            Цвет
        </td>
        <td colspan="2" class="bt bb br">
            <?= $order->colorDataName ?>
        </td>
        <td class="td-4">

        </td>
        <td class="td-5" style="position: relative">

        </td>
        <td class="td-6">

        </td>
    </tr>
    <tr>
        <td class="td-1 bt bb br">
            Подошва
        </td>
        <td colspan="2" class="bt bb br">
            <?= $order->getSoleContent() ?>
        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bt bl" style="position: relative">
            <?= $this->render('//order/print/_barcode', [
                'model' => $order,
                'className' => 'operation-barcode',
            ]) ?>
        </td>
        <td class="td-6 bt">

        </td>
    </tr>
    <tr>
        <td class="td-1 bt bb br">
            Колодка
        </td>
        <td colspan="2" class="bt bb br">
            <?= $order->modelLast ? $order->modelLast->name : '' ?>
        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bl" style="position: relative">

        </td>
        <td class="td-6">

        </td>
    </tr>
    <tr>
        <td class="td-1 bt bb br">
            Размер
        </td>
        <td colspan="5" class="bt bb br">
            <?= $order->size ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="devider long"></td>
    </tr>
    <tr>
        <td colspan="6" class="long"></td>
    </tr>
<!-- Операционный талон 1 -->
    <tr>
        <td colspan="4" class="bt bb br fs16">
            <b>ОПЕРАЦИОННЫЙ ТАЛОН №3</b>
        </td>
        <td colspan="2" class="td-5-6 bt bb fs16">
            <?= $order->id ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="short"></td>
    </tr>

    <tr>
        <td class="td-1 bt br">
            Пошив
        </td>
        <td colspan="2" class="bt br">

        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bt bl" style="position: relative">
            <?= $this->render('//order/print/_barcode', [
                'model' => $order,
                'className' => 'operation-barcode',
            ]) ?>
        </td>
        <td class="td-6 bt">

        </td>
    </tr>
    <tr>
        <td class="td-1 bb br">
            Сборка
        </td>
        <td colspan="2" class="bt bb br">

        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bb bl">

        </td>
        <td class="td-6 bb">

        </td>
    </tr>
    <tr>
        <td colspan="6" class="devider long"></td>
    </tr>
    <tr>
        <td colspan="6" class="long"></td>
    </tr>
<!-- Операционный талон 2 -->
    <tr>
        <td colspan="4" class="bt bb br fs16">
            <b>ОПЕРАЦИОННЫЙ ТАЛОН №2</b>
        </td>
        <td colspan="2" class="td-5-6 bt bb fs16">
            <?= $order->id ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="short"></td>
    </tr>

    <tr>
        <td class="td-1 bt br">
            Дублирование
        </td>
        <td colspan="2" class="bt br">

        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bt bl" style="position: relative">
            <?= $this->render('//order/print/_barcode', [
                'model' => $order,
                'className' => 'operation-barcode',
            ]) ?>
        </td>
        <td class="td-6 bt">

        </td>
    </tr>
    <tr>
        <td class="td-1 bb br">
            Наметка | Фортуна
        </td>
        <td colspan="2" class="bt bb br">

        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bb bl">

        </td>
        <td class="td-6 bb">

        </td>
    </tr>
    <tr>
        <td colspan="6" class="devider long"></td>
    </tr>
    <tr>
        <td colspan="6" class="long"></td>
    </tr>
<!-- Операционный талон 3 -->
    <tr>
        <td colspan="4" class="bt bb br fs16">
            <b>ОПЕРАЦИОННЫЙ ТАЛОН №1</b>
        </td>
        <td colspan="2" class="td-5-6 bt bb fs16">
            <?= $order->id ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="short"></td>
    </tr>

    <tr>
        <td class="td-1 bt br">
            Раскрой деталей
        </td>
        <td colspan="2" class="bt br">

        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bt bl" style="position: relative">
            <?= $this->render('//order/print/_barcode', [
                'model' => $order,
                'className' => 'operation-barcode',
            ]) ?>
        </td>
        <td class="td-6 bt">

        </td>
    </tr>
    <tr>
        <td class="td-1 bb br">
            Верха и подкладки
        </td>
        <td colspan="2" class="bt bb br">

        </td>
        <td class="td-4">

        </td>
        <td class="td-5 bb bl">

        </td>
        <td class="td-6 bb">

        </td>
    </tr>
</table>
<style>
    .operation-list-table {
        width: 190mm;
        border: 2px solid #ccc;
        margin: 10px 0;
    }
    .operation-list-table tr td {
        height: 10mm;
        padding-left: 5mm;
        padding-top: 1mm;
    }
    .operation-list-table tr td.null {
        height: 0;
        padding-top: 0;
    }
    .operation-list-table tr td.short {
        height: 5mm;
    }
    .operation-list-table tr td.long {
        height: 10mm;
    }
    .bt {
        border-top: 1px solid #ccc;
    }
    .bb {
        border-bottom: 1px solid #ccc;
    }
    .bl {
        border-left: 1px solid #ccc;
    }
    .br {
        border-right: 1px solid #ccc;
    }
    .devider {
        border-bottom: 4px dashed #ccc;
    }

    .td-1 {
        width: 21.05263157894737%;
        /*width: 40mm !important;*/
    }
    .td-2 {
        width: 18.42105263157895%;
        /*width: 35mm !important;*/
    }
    .td-3 {
        width: 21.05263157894737%;
        /*width: 40mm !important;*/
    }
    .td-4 {
        width: 7.89473684210526%;
        /*width: 15mm !important;*/
    }
    .td-5 {
        width: 15.78947368421053%;
        /*width: 30mm !important;*/
    }
    .td-6 {
        width: 15.78947368421053%;
        /*width: 30mm !important;*/
    }
    .td-5-6 {
        width: 31.57894736842105%;
        /*width: 30mm !important;*/
    }
    .td-1-4 {
        width: 68.42105263157895%;
    }
    .fs16 {
        font-size: 16px;
    }
    .operation-barcode {
        position: absolute;
        width: 60mm;
        top: 0;
        left: 0;
    }
    .operation-barcode .barcode-numbers {
        font-size: 13px;
    }
    .operation-barcode .barcode-content svg {
        height: 30px;
    }
    .operation-barcode.barcode-block .barcode-content-box {
        border: none;
        padding: 5px 0;
    }
    .operation-barcode.barcode-block table {
        border: none;
    }
</style>
