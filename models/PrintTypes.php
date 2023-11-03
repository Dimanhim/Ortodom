<?php

namespace app\models;

class PrintTypes
{
    const RECEIPT = 1;
    const FORM = 2;
    const CASH_RECEIPT_ORDER = 3;
    const WARRANTY_CARD = 4;
    const ACT = 5;
    const SALES_RECEIPT = 6;
    const CONTRACT = 7;
    const WARRANTY_KSP = 8;

    const ACT_LO = 9;
    const ACT_LO_2023 = 12;
    const CONTRACT_LO = 10;


    const BARCODES = 11;

    const PRICE_LO = 8436.3;
    const PRICE_LO_TEXT = '8436 (восемь тысяч четыреста тридцать шесть) рублей 30 копеек';

    const PRICE_LO_2023 = 9307.4;
    const PRICE_LO_TEXT_2023 = '9307 (девять тысяч триста семь) рублей 40 копеек';
}
