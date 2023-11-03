<?php

use app\components\Calendar;
use app\models\Visit;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Приемы';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile('js/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('js/bootstrap-datepicker.ru.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerCssFile('css/bootstrap-datepicker.min.css');

$dates = $calendar->getDatesArray($actual_date, Visit::SHOW_DAYS_RECORDS);
$times = $calendar->timeArray;
$freeWeek = Visit::getFreeWeek(Visit::SHOW_DAYS_RECORDS);
?>

<div id="show-modal-container"></div>

<div class="visit-index">
    <div class="row" style="margin: 20px 0;">
        <div class="col-md-8">
            <h3 style="margin-top: 0;">Выберите свободную ЗЕЛЁНУЮ ячейку для записи на приём</h3>
            <p>если нет свободных для записи ячеек - перейдите по стрелочкам на следующую неделю</p>
        </div>
        <div class="col-md-4">
            <div class="btn-group date-change-buttons">
                <?php if($week_count == 0) : ?>
                    <a href="?week=<?= $week_count - 1 ?>" type="button" class="btn btn-default">«</a>
                    <a href="?week=<?= $freeWeek ?>" type="button" class="btn btn-success">Свободные даты</a>
                    <a href="?week=<?= $week_count + 1 ?>" type="button" class="btn btn-default">»</a>
                <?php else : ?>
                    <a href="?week=<?= $week_count - 1 ?>" type="button" class="btn btn-default">«</a>
                    <a href="/record" type="button" class="btn btn-default">Текущие 2 недели</a>
                    <a href="?week=<?= $week_count + 1 ?>" type="button" class="btn btn-default">»</a>

                <?php endif; ?>
            </div>
        </div>
    </div>


    <table class="table table-bordered table-visit">
        <tr>
            <?php foreach($dates as $val) : ?>
                <th>
                    <?= $val['date_short_string'] ?>
                </th>
            <?php endforeach; ?>
        </tr>
        <?php foreach($times as $value) : ?>
        <tr>
            <?php foreach($dates as $val) : ?>
                <?php
                    $cell_values['disabled'] = $calendar->cellDisabled($actual_date, $value, $val['timestamp']);
                    $cell_values['class'] = $cell_values['disabled'] ? ' disabled-cell' : ' td-avalible td-record-avalible' ;
                    $cell_values['content'] = $cell_values['disabled'] ? $calendar->cellContent($value, $val['timestamp']) : $value ;
                    $cell_values['id'] = $cell_values['disabled'] ? $calendar->cellContent($value, $val['timestamp'], true) : '' ;
                ?>
                <td class="<?= $cell_values['class'] ?>" style="height: 50px;" data-id="<?= $cell_values['id'] ?>" data-time="<?= $value ?>" data-time-val="<?= $calendar->getSecondsInTime($value) ?>" data-date="<?= $val['date_format'] ?>" data-date-val="<?= $val['timestamp'] ?>">
                    <?= $value ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<div style="display: none">
    <?php
    echo DatePicker::widget([
        'name' => 'name',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
            'clearBtn' => true,
            'todayHighlight' => true,
        ],
        'language' => 'ru',
    ]);
    ?>
</div>
