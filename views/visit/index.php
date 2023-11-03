<?php

use app\components\Calendar;
use app\models\Visit;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Приемы';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile('js/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('js/bootstrap-datepicker.ru.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerCssFile('css/bootstrap-datepicker.min.css');

$dates = $calendar->getDatesArray($actual_date, Visit::SHOW_DAYS);

$times = $calendar->timeArray;
?>

<div id="show-modal-container"></div>

<div class="visit-index">
    <?php $form = ActiveForm::begin(['id' => 'visit-form', 'method' => 'GET', 'action' => 'visit/change-visit-week', 'fieldConfig' => ['options' => ['tag' => false]]]) ?>
    <div class="row">
        <div class="col-md-3">
            <h1 style="margin-top: 0;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                    <a href="<?= Url::to(['visit/free-week']) ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </a>
                </div>
                <div class="col-md-12 col-sm-10 col-xs-10">
                    <?= $form->field($visitForm, 'date', ['template' => "{input}"])->widget(DatePicker::className(), [
                        'inline' => false,
                        'options' => [
                            'class' => 'change-visit-week date-time-widget',
                            'value' => $visitForm->modelDate,
                        ],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                        ],
                        'language' => 'ru',
                    ]) ?>
                </div>
            </div>
            <?= Html::submitButton('показать', ['class' => "btn hidden"]) ?>
        </div>
        <div class="col-md-2">
            <div class="visible-lg visible-md">
                <a href="<?= Url::to(['visit/free-week']) ?>" class="btn btn-success">
                    Свободные даты
                </a>
            </div>

        </div>
        <div class="col-md-5 date-change-buttons-container">
            <div class="hidden-lg">
                <div class="row">

                    <div class="col-xs-10">
                        <?/*= $form->field($visitForm, 'date', ['template' => "{input}"])->widget(DatePicker::className(), [
                            'inline' => false,
                            'options' => [
                                'class' => 'change-visit-week',
                                'id' => 'visitform-date-mobile',
                                'value' => $visitForm->modelDate,
                            ],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy',
                                'todayHighlight' => true,
                            ],
                            'language' => 'ru',
                        ])*/ ?>
                    </div>
                    <div class="col-xs-12" style="margin-top: 20px; text-align: center;">
                        <div class="btn-group date-change-buttons" style="margin-bottom: 20px;">
                            <a href="?week=<?= $week_count - 1 ?>" type="button" class="btn btn-default">«</a>
                            <a href="/visit" type="button" class="btn btn-default btn-text">Текущая неделя</a>
                            <a href="?week=<?= $week_count + 1 ?>" type="button" class="btn btn-default">»</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="visible-lg">
                <div class="btn-group date-change-buttons pull-right" style="margin-bottom: 20px;">
                    <a href="?week=<?= $week_count - 1 ?>" type="button" class="btn btn-default">«</a>
                    <a href="/visit" type="button" class="btn btn-default btn-text">Текущая неделя</a>
                    <a href="?week=<?= $week_count + 1 ?>" type="button" class="btn btn-default">»</a>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>


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
                    $cell_values['disabled'] = $calendar->cellDisabled($actual_date, $value, $val['timestamp']);
                    $cell_values['class'] = $cell_values['disabled'] ? ' disabled-cell td-disabled' : ' td-avalible' ;
                    $cell_values['content'] = $cell_values['disabled'] ? $calendar->cellContent($value, $val['timestamp']) : $value ;
                    $cell_values['id'] = $cell_values['disabled'] ? $calendar->cellContent($value, $val['timestamp'], true) : '' ;
                ?>
                <td class="<?= $cell_values['class'] ?>" data-id="<?= $cell_values['id'] ?>" data-time="<?= $value ?>" data-time-val="<?= $calendar->getSecondsInTime($value) ?>" data-date="<?= $val['date_format'] ?>" data-date-val="<?= $val['timestamp'] ?>">
                    <?= $cell_values['content'] ?>
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
        'options' => [
            'class' => 'date-time-widget',
        ],
        'language' => 'ru',
    ]);
    ?>
</div>
