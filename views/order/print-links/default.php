<?php
use app\models\PrintTypes;
?>
<div class="col-md-12">
    <div class="col-md-6">
        <h3>Документы при приеме заказа</h3>

        <ul style="list-style: none">
            <li><input class="print" type="checkbox" value="<?= PrintTypes::RECEIPT ?>"> Квитанция о приеме</li>
            <li><input class="print" type="checkbox" value="<?= PrintTypes::FORM ?>"> Бланк заказа</li>
            <li><input class="print" type="checkbox" value="<?= PrintTypes::CASH_RECEIPT_ORDER ?>"> Приходно-кассовый ордер (виден если форма оплаты н/р или возмещение)</li>
        </ul>
    </div>
    <div class="col-md-6">
        <h3>Документы при выдаче заказа</h3>

        <ul style="list-style: none">
            <li><input class="print" type="checkbox" value="<?= PrintTypes::WARRANTY_CARD ?>"> Гарантийный талон</li>
            <li><input class="print" type="checkbox" value="<?= PrintTypes::WARRANTY_KSP ?>"> Гарантийный КСП</li>
            <li>
                <input class="print" type="checkbox" value="<?= PrintTypes::ACT ?>"> Акт выполненных работ - 2 шт (виден если форма оплаты н/р или возмещение)
            </li>
            <li><input class="print" type="checkbox" value="<?= PrintTypes::SALES_RECEIPT ?>"> Товарный чек (виден если форма оплаты н/р или возмещение)</li>
            <li>
                <input class="print" type="checkbox" value="<?= PrintTypes::CONTRACT ?>"> Договор - 2 шт (виден если форма оплаты н/р или возмещение)
            </li>
        </ul>
    </div>
</div>
