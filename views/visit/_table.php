<?php

use Yii;
use app\models\Visit;

$dates = $calendar->getDatesArray($actual_date, Visit::SHOW_DAYS);

$times = $calendar->timeArray;

?>

<table class="table table-bordered table-visit">
    <tr>
        <?php foreach($dates as $val) : ?>
            <th>
                <?= $val['date_string'].'<br>'.$val['user_name'] ?>
            </th>
        <?php endforeach; ?>
    </tr>
    <?php foreach($times as $value) : ?>
        <tr>
            <?php foreach($dates as $val) : ?>
                <?php
                $cell_values['status'] = $calendar->statusCell($actual_date, $value, $val['timestamp']);
                switch ($cell_values['status']) {
                    case Visit::STATUS_CELL_AVALIABLE : {
                        $cell_values['class'] = ' td-avalible';
                        $cell_values['content'] = $value;
                        $cell_values['id'] = '';
                    }
                        break;
                    case Visit::STATUS_CELL_DISABLED : {
                        $cell_values['class'] = ' disabled-cell td-disabled';
                        $cell_values['content'] = $calendar->cellContent($value, $val['timestamp']);
                        $cell_values['id'] = $calendar->cellContent($value, $val['timestamp'], true);
                    }
                        break;
                    case Visit::STATUS_CELL_RESERVED : {
                        $cell_values['class'] = Yii::$app->user->isGuest ? ' disabled-cell td-disabled' : ' td-reserved';
                        $cell_values['content'] = $value;
                        $cell_values['id'] = Yii::$app->user->isGuest ? '' : $calendar->cellContent($value, $val['timestamp'], true);
                    }
                        break;
                }

                //$cell_values['disabled'] = $calendar->cellDisabled($actual_date, $value, $val['timestamp']);
                //$cell_values['class'] = $cell_values['disabled'] ? ' disabled-cell td-disabled' : ' td-avalible' ;
                //$cell_values['content'] = $cell_values['disabled'] ? $calendar->cellContent($value, $val['timestamp']) : $value ;
                //$cell_values['id'] = $cell_values['disabled'] ? $calendar->cellContent($value, $val['timestamp'], true) : '' ;
                ?>
                <?= $this->render('_cell', [
                    'cell_values' => $cell_values,
                    'time' => $value,
                    'calendar' => $calendar,
                    'date' => $val,
                ]) ?>

                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
