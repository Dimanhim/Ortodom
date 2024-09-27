<?php

namespace app\components;


use app\models\Visit;
use app\models\VisitUser;
use yii\base\Model;

class Calendar extends Model
{
    public function getTimeArray()
    {
        return [
            '10:00','10:30','11:00','11:30','12:00','12:30',
            '13:00','13:30','15:00','15:30',
            '16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:15',

        ];
    }
    public function getWorkTimeArray()
    {
        return [
            '10:00','10:30','11:00','11:30','12:00','12:30',
            '13:00','13:30',
            '15:00','15:30',
            '16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:15'

        ];
    }
    public static function getTimestampTimesArray()
    {
        $result = [];
        foreach(self::getWorkTimeArray() as $timeString) {
            $result[] = self::getSecondsInTime($timeString);
        }
        return $result;
    }
    public function monthArray()
    {
        return [
            1 => ['января','янв'],
            2 => ['февраля','фев'],
            3 => ['марта','мар'],
            4 => ['апреля','апр'],
            5 => ['мая','мая'],
            6 => ['июня','июня'],
            7 => ['июля','июля'],
            8 => ['августа','авг'],
            9 => ['сентября','сен'],
            10 => ['октября','окт'],
            11 => ['ноября','ноя'],
            12 => ['декабря','дек'],
        ];
    }
    public function weekDaysArray()
    {
        return [
            1 => ['Понедельник', 'пн'],
            2 => ['Вторник', 'вт'],
            3 => ['Среда', 'ср'],
            4 => ['Четверг', 'чт'],
            5 => ['Пятница', 'пт'],
            6 => ['Суббота', 'сб'],
            7 => ['Воскресенье', 'вс'],
        ];
    }

    /**
     * @param bool $actual_date - format timestamp
     * @param int $count_days - days a week in table
     * @return array
     */
    public function getDatesArray($actual_date = false, $count_days = 8)
    {
        $array = [];
        $time = $actual_date ? $actual_date : strtotime(date('d.m.Y'));
        for($i = 0; $i < $count_days; $i++) {
            $current_time = $time + 86400 * $i;
            if(date('N', $current_time) != 7) {
                $array[$i]['timestamp'] = $current_time;
                $array[$i]['date_format'] = date('d.m.Y', $current_time);
                $array[$i]['date_string'] = $this->weekDaysArray()[date('N', $current_time)][1].' '.
                    date('d', $current_time).' '.
                    $this->monthArray()[date('n', $current_time)][1].' '.
                    date('Y');
                $array[$i]['date_short_string'] = $this->weekDaysArray()[date('N', $current_time)][1].' '.
                    date('d', $current_time).' '.
                    $this->monthArray()[date('n', $current_time)][1];
                $array[$i]['user_name'] = VisitUser::userName($current_time);
            }
        }
        return $array;
    }
    public static function getSecondsInTime($time)
    {
        $seconds = 0;
        $arr = explode(':', $time);
        $seconds += $arr[0] * 60 * 60;
        $seconds += $arr[1] * 60;
        return $seconds;
    }
    public static function getTimeAsString($time)
    {
        if($time) {
            $hours = floor($time / 60 / 60);
            $diff = $time - $hours * 60 * 60;
            $minutes = floor($diff / 60);
            return str_pad($hours, 2, 0, STR_PAD_LEFT).':'.str_pad($minutes, 2, 0, STR_PAD_LEFT);
        }
        return 0;
    }
    public function getStaticTime($time)
    {
        $diff = $time / 3600;
        $hours = floor($diff);
        if(($diff - $hours) > 0.5) $minutes = '30';
        else $minutes = '00';
        return Calendar::getSecondsInTime($hours.':'.$minutes);
    }
    public function getDisabledCells($actual_date, $count_days = 8)
    {
        $result = [];
        $begin_date = $actual_date;
        $end_date = $actual_date + 86400 * $count_days;
        if($visits = Visit::find()->where(['>=', 'visit_date', $begin_date])->andWhere(['<=', 'visit_date', $end_date])->all()) {
            foreach($visits as $key => $visit) {
                $result[$key]['time'] = ($visit->visit_time == self::getSecondsInTime('19:30')) ? self::getSecondsInTime('19:15') : $visit->visit_time;
                $result[$key]['date'] = $visit->visit_date;
                $result[$key]['reserved'] = $visit->reserved;
            }
        }
        return $result;
    }
    public function statusCell($actual_date, $time, $date)
    {
        //$disabled_times = [46800, 48600];
        $disabled_times = [50400, 52200];
        $time = $this->getSecondsInTime($time);
        $disabled_cells = $this->getDisabledCells($actual_date, Visit::SHOW_DAYS_RECORDS);
        foreach($disabled_cells as $val) {
            if((($val['date'] == $date) && ($val['time'] == $time)) || (in_array($time, $disabled_times))) {
                return $val['reserved'] ? Visit::STATUS_CELL_RESERVED : Visit::STATUS_CELL_DISABLED;
            }
        }
        return Visit::STATUS_CELL_AVALIABLE;
    }
    public function cellDisabled($actual_date, $time, $date)
    {
        //$disabled_times = [46800, 48600];
        $disabled_times = [50400, 52200];
        $time = $this->getSecondsInTime($time);
        $disabled_cells = $this->getDisabledCells($actual_date, Visit::SHOW_DAYS_RECORDS);
        foreach($disabled_cells as $val) {
            if((($val['date'] == $date) && ($val['time'] == $time)) || (in_array($time, $disabled_times))) return true;
        }
        return false;
    }
    public function cellContent($time, $date, $id = false)
    {
        $time = $this->getSecondsInTime($time);
        if($visit = Visit::findOne(['visit_time' => $time, 'visit_date' => $date])) {
            if($id) {
                return $visit->id;
            }
            $str = $visit->name.'<br>';
            if($visit->is_insoles) $str .= '<span class="table-info">С</span>';
            if($visit->is_children) $str .= '<span class="table-info">Д</span>';
            if($visit->is_fitting) $str .= '<span class="table-info">П</span>';
            $str .= $visit->phone;
            return $str;

        }
        elseif($time == $this->getSecondsInTime('19:15') && ($visit = Visit::findOne(['visit_time' => $time + 15 * 60, 'visit_date' => $date]))) {

            if($id) {
                return $visit->id;
            }
            $str = $visit->name.'<br>';
            if($visit->is_insoles) $str .= '<span class="table-info">С</span>';
            if($visit->is_children) $str .= '<span class="table-info">Д</span>';
            if($visit->is_fitting) $str .= '<span class="table-info">П</span>';
            $str .= $visit->phone;
            return $str;
            return $id ? $visit->id : $visit->name.'<br>'.$visit->phone;
        }
        return '';
    }

    public function getTableValues($actual_date = null, $showDays = 30 * 6)
    {
        //$actual_date = strtotime('15.06.2023');
        $time = $actual_date ? $actual_date : strtotime(date('d.m.Y'));
        $dates = $this->getDatesArray($time, $showDays);
        $data = self::getStaticTable($dates);
        if($dates) {
            foreach($dates as $date) {
                $currentWeekDay = date('N', $date['timestamp']);
                $currentWeek = date('W', $date['timestamp']);
                $cellValues = VisitUser::cellValues($date['timestamp']);
                $data[$currentWeek][$currentWeekDay] = [
                    'timestamp' => $date['timestamp'],
                    'date_format' => $date['date_format'],
                    'disabled' => $cellValues['disabled'],
                    'class' => $cellValues['class']
                ];

            }
        }
        return $data;
    }

    public static function getStaticTable($dates)
    {
        $begin = $dates[0]['timestamp'];
        $end = end($dates)['timestamp'];
        $beginWeek = date('W', $begin);
        $endWeek = date('W', $end);
        $data = [];
        for($i = 0; $i < ($endWeek - $beginWeek); $i++) {
            for($j = 1; $j <= 7; $j++) {
                $data[$beginWeek + $i][$j] = '';
            }
        }
        return $data;
    }

}
?>
