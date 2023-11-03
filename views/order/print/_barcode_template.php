<div class="barcode-block">
    <table>
        <!--
        <tr>
            <td colspan="2">
                <div class="barcode-content-box">
                    <div>
                        Номер заказа: <?= $model->getFullId() ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="barcode-content-box">
                    <div>
                        Модель: <?//= $model->shoes->name ?>
                    </div>
                </div>
            </td>
        </tr>
        -->
        <tr>
            <td colspan="2">
                <div class="barcode-content-box">
                    <div class="barcode-representative_name">
                        <?= $model->patient ? $model->patient->full_name : '---' ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center">
                <div class="barcode-content-box">
                    <div class="barcode-barcode">
                        <?= $model->barcodeView ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<style>
    .barcode-block {
        width: 300px;
        font-size: 18px;
    }
    .barcode-block table {
        width: 100%;
        border: 1px solid #000;
    }
    .barcode-block table tr td {
        padding: 1px;
    }
    .barcode-block table tr td.center div {
        /*margin: auto;*/
    }
    .barcode-block .barcode-content-box {
        border: 1px solid #000;
        padding: 10px;
    }
    .barcode-block .barcode-center {
        text-align: center;
    }
    .barcode-block .barcode-bold {
        font-weight: bold;
    }
    .barcode-block .barcode-barcode {
        min-height: 50px;
        text-align: center;
    }
    .barcode-representative_name {
        min-height: 18px;
    }
    .barcode-content {
        margin-bottom: 10px;
    }
</style>
