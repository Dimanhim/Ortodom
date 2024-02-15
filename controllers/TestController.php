<?php

namespace app\controllers;

use app\components\Calendar;
use app\models\OrderStatusDate;
use app\models\Visit;
use yii\web\Controller;
use yii\helpers\Inflector;

class TestController extends Controller
{
    public function actionIndex()
    {
        $created_at_begin = '09.02.2024 15:25';
        $created_at_end = '11.02.2024 17:51';
        $phones = [];
        $orderDates = [];
        $ids_1 = [
            22629, 24347, 24345, 24343, 24341, 24340, 23010,
            22777, 22572, 24338, 24335, 24332, 24331, 24329,
            24327, 24325, 24323, 24321, 24319, 24317, 24313, 22092, 24309, 23661, 24308,

            24307, 24310, 24311, 24315, 24316, 24318, 24320, 24322, 24324, 24326, 24328,
            24330, 24333, 24346, 24344, 24342, 24337, 24334, 24336, 24314, 24312
        ];
        $ids_2 = [
            22822, 22767, 22794, 23787, 22796, 22781, 22611,
            22713, 22482, 22343, 22789, 22773, 23295, 24208, 22720
        ];
        $ids = array_merge($ids_1, $ids_2);

        $orderDateModels = OrderStatusDate::find()
            ->joinWith(['order'])
            ->where(['between', 'order_status_dates.created_at', strtotime($created_at_begin), strtotime($created_at_end)])
            ->andWhere('orders.status_id = 3 or orders.status_id = 1')
            ->andWhere(['not in', 'orders.id', $ids])
            ->orderBy(['order_status_dates.created_at' => SORT_DESC])
            ->all();
        foreach($orderDateModels as $orderDate) {
            if(!in_array($orderDate->order->patient->phone, $phones)) {
                $orderDates[] = $orderDate;
                $phones[] = $orderDate->order->patient->phone;
            }
        }

        return $this->render('index', [
            'orderDates' => $orderDates,
        ]);
    }

    public function actionWidget()
    {
        $this->layout = 'empty';
        return $this->render('widget');
    }
}
