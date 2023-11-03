<?php

use app\models\Patient;
use moonland\phpexcel\Excel;

Excel::widget([
    'models' => $model,
    'mode' => 'export',
    'fileName' => 'export.xlsx',
    'asAttachment' => true,
    'columns' => [
        'full_name',
        'birthday',
        'address',
        'phone',
    ],
]);

