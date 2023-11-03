<?php
use app\models\PrintTypes;
?>
<div class="col-md-12">
    <div class="col-md-6">
        <h3>Документы при приеме заказа</h3>

        <ul style="list-style: none">
            <li><input class="print" type="checkbox" value="<?= PrintTypes::RECEIPT ?>"> Квитанция о приеме</li>
            <li><input class="print" type="checkbox" value="<?= PrintTypes::FORM ?>"> Бланк заказа</li>
            <li>
                <input class="print" type="checkbox" value="<?= PrintTypes::CONTRACT_LO ?>"> Договор - 3 шт
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <h3>Документы при выдаче заказа</h3>

        <ul style="list-style: none">
            <li><input class="print" type="checkbox" value="<?= PrintTypes::WARRANTY_CARD ?>"> Гарантийный талон</li>
            <li><input class="print" type="checkbox" value="<?= PrintTypes::WARRANTY_KSP ?>"> Гарантийный КСП</li>
            <li>
                <input class="print" type="checkbox" value="<?= (isset($new) && $new) ? PrintTypes::ACT_LO_2023 : PrintTypes::ACT_LO ?>"> Акт выполненных работ - 3 шт
            </li>
        </ul>
    </div>
</div>

