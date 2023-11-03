<?php

namespace app\controllers;

use app\components\Calendar;
use app\models\Visit;
use yii\web\Controller;
use yii\helpers\Inflector;

class TestController extends Controller
{
    public function actionIndex()
    {
        $days_ago = 1;

        // искомая дата
        $searchedDate = strtotime(date('d.m.Y', strtotime("+{$days_ago} day")));

        // настоящее время в секундах 36000
        $nowTime = Calendar::getSecondsInTime(date('H:i'));
        $searchedTimeBegin = floor($nowTime / 3600) * 3600;
        $searchedTimeEnd = ceil($nowTime / 3600) * 3600;

        echo "<pre>";
        //print_r(date('d.m.Y H:i', $searchedDate));
        print_r($searchedDate);
        echo "</pre>";
        exit;
        $visits = Visit::find()
            ->where(['visit_date' => $searchedDate])
            ->andWhere(['between', 'visit_time', $searchedTimeBegin, $searchedTimeEnd])
            ->andWhere(['send_reminder_day_sms' => null])
            ->all();

        foreach($visits as $visit) {
            echo $visit->id.'<br>';
        }
        exit;
    }
}
