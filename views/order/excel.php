<?php

use moonland\phpexcel\Excel;

Excel::widget([
    'models' => $models,
    'mode' => 'export',
    'fileName' => 'orders',
    'asAttachment' => true,
    'columns' => [
        [
            'attribute' => 'id',
            'value' => function ($data) {
                return $data->fullId;
            },
        ],
        [
            'attribute' => 'payment_id',
            'value' => function ($data) {
                return $data->payment ? $data->payment->name : '-';
            },
        ],
        [
            'attribute' => 'patient_id',
            'value' => function ($data) {
                return $data->patient ? $data->patient->full_name : '-';
            },
        ],
        [
            'attribute' =>'representative_name',
        ],
        [
            'attribute' =>'referral',
        ],
        [
            'attribute' => 'shoes_id',
            'value' => function ($data) {
                return $data->shoes ? $data->shoes->name : '-';
            },
        ],
        [
            'attribute' => 'diagnosis_id',
            'value' => function ($data) {
                return $data->diagnosis ? $data->diagnosis->name : '-';
            },
        ],
        [
            'attribute' => 'accepted',
            'format' => 'raw',
            'value' => function ($data) {
                return $data->accepted;
            },
        ],
        [
            'attribute' => 'issued',
            'value' => function ($data) {
                return $data->issuedDates;
            },
        ],
        [
            'attribute' => 'Дата посл. переделки',
            'value' => function($data) {
                return $data->getRedoneDates();
            },
        ],
        [
            'attribute' =>'prepaid',
        ],
        [
            'attribute' =>'cost',
        ],
        [
            'attribute' => 'status_id',
            'value' => function ($data) {
                return $data->status_id ? $data->statusName.' '.$data->lastChangeStatus() : '-';
            },
        ],
    ],
]);



