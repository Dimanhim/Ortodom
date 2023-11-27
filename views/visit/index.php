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
                    <a href="<?= Url::to(['visit/free-week']) ?>" class="btn btn-success btn-for-finger">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                    <a href="#" class="btn btn-warning btn-for-finger btn-reserve">
                        <i class="glyphicon glyphicon-check"></i>
                    </a>
                </div>
                <div class="col-md-12 col-sm-8 col-xs-8">
                    <div style="margin-top: 7px;">
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
            </div>
            <?= Html::submitButton('показать', ['class' => "btn hidden"]) ?>
        </div>
        <div class="col-md-3" style="display: flex">
            <div class="visible-lg visible-md">
                <a href="<?= Url::to(['visit/free-week']) ?>" class="btn btn-success">
                    Свободные даты
                </a>
            </div>
            <div class="visible-lg visible-md" style="margin-left: 10px;">
                <a href="#" class="btn btn-warning btn-reserve">
                    Бронь
                </a>
            </div>
        </div>
        <div class="col-md-4 date-change-buttons-container">
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

    <?= $this->render('_table', [
        'calendar' => $calendar,
        'actual_date' => $actual_date,

    ]) ?>

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
