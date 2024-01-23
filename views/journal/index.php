<?php

use app\models\Patient;
use app\models\Order;
use app\modules\directory\models\Diagnosis;
use app\modules\directory\models\Payment;
use app\modules\directory\models\Shoes;
use dosamigos\datepicker\DatePicker;
use vova07\select2\Widget;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(['id' => 'form-order-search', 'method' => 'get', 'class' => 'form-horizontal']); ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="">Период приема</label>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $form->field($searchModel, 'acceptedStart')->widget(
                            DatePicker::className(), [
                            'inline' => false,
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy',
                                'todayHighlight' => true,
                            ],
                            'options' => [
                                'class' => 'date-time-widget',
                            ],
                            'language' => 'ru',
                        ])->label(false); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $form->field($searchModel, 'acceptedEnd')->widget(
                            DatePicker::className(), [
                            'inline' => false,
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy',
                                'todayHighlight' => true,
                            ],
                            'options' => [
                                'class' => 'date-time-widget',
                            ],
                            'language' => 'ru',
                        ])->label(false); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <?php echo Html::submitButton('Фильтровать', ['class' => 'btn btn-warning', 'style' => 'margin-top: 24px']); ?>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-3 draw-items">
            <?= $form->field($searchModel, 'changeStatusForm')->dropDownList(Order::statusNamesArray(), ['prompt' => '--Выбрать--']) ?>
        </div>
        <div class="col-lg-1">
            <?php if($searchModel->status_id == 2) : ?>
                <?= Html::submitButton('Печать', ['id' => 'print-order-to-send', 'class' => 'btn btn-primary pull-right', 'style' => 'margin-top: 24px']) ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-1">
            <?php echo Html::a('Печать ШК', '#', ['id' => 'print-barcodes', 'class' => 'btn btn-primary', 'style' => 'margin-top: 24px']); ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['style' => $model->getJournalColorsArray(), 'class' => 'row-item'];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',],
            [
                'header' => $searchModel->getHeaderId(),
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->fullId;
                },
                'contentOptions' => ['class' => 'order-id'],
                'headerOptions' => ['style' => 'width: 120px;'],
            ],
            [
                'attribute' => 'patient_id',
                'contentOptions' => ['class' => 'fix-row'],
                'headerOptions' => ['style' => 'width: 150px;'],
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->patient ? $data->patient->fullName : '-';
                },
                'filter' => Widget::widget([
                    'model' => $searchModel,
                    'attribute' => 'patient_id',
                    'options' => [
                        'multiple' => true,
                        'placeholder' => 'Выбрать',
                    ],
                    'settings' => [
                        'width' => '100%',
                    ],
                    'items' => ArrayHelper::map(Patient::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'),
                ]),
            ],
            [
                'attribute' => 'brand_id',
                'value' => function($data) {
                    return $data->getModelName();
                }
            ],
            [
                'attribute' => 'lining_id',
                'value' => function($data) {
                    return $data->modelLining ? $data->modelLining->name : false;
                }
            ],
            [
                'attribute' => 'color_id',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getColorDataName();
                }
            ],
            [
                'attribute' => 'Этапы заказа',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getOrderSteps();
                }
            ],
            [
                'attribute' => 'Этапы производства',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getProductionSteps();
                }
            ],
            [
                'attribute' => 'accepted',
                'value' => function ($data) {
                    return $data->accepted;
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'accepted',
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
                ]),
            ],
            [
                'attribute' => 'status_id',
                //'contentOptions' => ['class' => 'fix-row-min'],
                'value' => function ($data) {
                    return $data->status_id ? $data->statusName : '-';
                },
                'filter' => Order::statusNamesArray(),
                'filterOptions' => ['class' => 'draw-items'],
                'filterInputOptions' => ['class' => 'form-control search-status', 'data-id' => $model->id],
            ],
            /*[
                'attribute' => 'highlightLine',
                'format' => 'raw',
                'value' => function() {
                    return '';
                },
                'filter' => Order::highlightsColors(false),
                'filterOptions' => [
                    'class' => 'highlights-filter',
                ],
            ],*/
            [
                'attribute' => 'checkbox',
                'format' => 'raw',
                'value' => function() {
                    return Html::checkbox('');
                },
                'contentOptions' => ['class' => 'order-checkbox'],
                'filter' => '<input type="checkbox" id="checkbox-select-orders" />'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}{print}',
                'buttons' => [
                    'print' => function($url, $model, $key) {
                        $link = Yii::$app->urlManager->createAbsoluteUrl(['/images/scan/'.$model->scan]);
                        return Html::a('<img src="/images/leg-icon.png" class="leg-icon" />', $link, ['class' => 'buttonPrint']);
                    }
                ],
            ],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
    <div class="panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">

                </div>
                <div class="col-md-2">
                    <?= Html::a('Печать', '#', ['class' => 'btn btn-primary pull-right outfit-btn', 'id' => 'outfit-btn', 'data-type' => 4]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="view-modal">
    <div class="modal" id="order-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div id="select-orders-checkboxes">
                        <?php $form = ActiveForm::begin(['id' => 'form-order', 'method' => 'get']) ?>
                        <?= $form->field($searchModel, 'id')->textInput(['placeholder' => "Введите id заказов", 'autofocus' => 'autofocus']) ?>
                        <?= Html::submitButton('Выбрать', ['class' => "btn btn-success"]) ?>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    table tr td, table tr th {
        font-size: 12px;
    }
    .fix-row {
        width: 90px;
    }
    .fix-row-min {
        width: 80px;
    }
    .select2-choices {
        width: 90px;
    }
    <?php foreach(Order::statusStylesArray() as $k => $v) : ?>
    .draw-items select option[value="<?= $k ?>"] {
        <?= $v ?>
    }
    <?php endforeach; ?>

    <?php foreach(Order::highlightsColors() as $k => $v) : ?>
    .highlights-filter select option[value="<?= $k ?>"] {
        <?= $v ?>
    }
    <?php endforeach; ?>
</style>
