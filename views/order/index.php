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

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p class="text-right">
        <?php echo Html::a('Новый заказ', ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(['id' => 'form-order-search', 'method' => 'get', 'class' => 'form-horizontal']); ?>
        <div class="row">
            <div class="col-lg-offset-2 col-lg-2">
                <?= $form->field($searchModel, 'changeStatusForm')->dropDownList(Order::statusNamesArray(), ['prompt' => '--Выбрать--']) ?>
            </div>
            <div class="col-lg-2">
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
                ]); ?>
            </div>
            <div class="col-lg-2">
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
                ]); ?>
            </div>
            <div class="col-lg-1">
                <?php echo Html::submitButton('Фильтровать', ['class' => 'btn btn-warning', 'style' => 'margin-top: 24px']); ?>
            </div>
            <div class="col-lg-1">
                <?php echo Html::a('Эксель', ['order/excel', 'OrderSearch' => Yii::$app->request->queryParams['OrderSearch']], ['class' => 'btn btn-warning', 'style' => 'margin-top: 24px']); ?>
            </div>
            <div class="col-lg-1">
                <?php
                    if($searchModel->status_id == 2) {
                        echo Html::submitButton('Печать', ['id' => 'print-order-to-send', 'class' => 'btn btn-primary', 'style' => 'margin-top: 24px']);
                    }
                ?>
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
                return ['style' => $model->statusStyle, 'class' => 'row-item'];
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
                    'headerOptions' => ['style' => 'width: 65px;'],
                ],
                [
                    'attribute' => 'payment_id',
                    'value' => function ($data) {
                        return $data->payment ? $data->payment->name : '-';
                    },
                    'filter' => ArrayHelper::map(Payment::find()->asArray()->all(), 'id', 'name'),
                    'headerOptions' => ['style' => 'width: 105px;'],
                ],
                [
                    'attribute' => 'patient_id',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'fix-row'],
                    'headerOptions' => ['style' => 'width: 140px;'],
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
                            'class' => 'form-control',
                        ],
                        'items' => ArrayHelper::map(Patient::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'),
                    ]),
                ],
                [
                    'attribute' => 'representative_name',
                    'contentOptions' => ['class' => 'fix-row'],
                    'headerOptions' => ['style' => 'width: 140px; white-space: break-spaces'],
                    'value' => function($data) {
                        return $data->representativeName;
                    }
                ],
                [
                    'attribute' => 'referral',
                    'contentOptions' => ['class' => 'fix-row'],
                    'headerOptions' => ['style' => 'width: 95px; white-space: break-spaces'],
                ],
                [
                    'attribute' => 'shoes_id',
                    'contentOptions' => ['class' => 'fix-row'],
                    'value' => function ($data) {
                        return $data->shoes ? $data->shoes->name : '-';
                    },
                    'filter' => ArrayHelper::map(Shoes::find()->asArray()->all(), 'id', 'name'),
                ],
                [
                    'attribute' => 'diagnosis_id',
                    'contentOptions' => ['class' => 'fix-row'],
                    'value' => function ($data) {
                        return $data->diagnosis ? $data->diagnosis->name : '-';
                    },
                    'filter' => ArrayHelper::map(Diagnosis::find()->asArray()->all(), 'id', 'name'),
                    'headerOptions' => ['style' => 'width: 170px;'],
                ],
                [
                    'attribute' => 'accepted',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->accepted;
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'accepted',
                        'addon' => '',
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
                    'headerOptions' => ['style' => 'width: 114px;'],
                ],
                [
                    'attribute' => 'issued',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->issuedDates;
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'issued',
                        'addon' => '',
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
                    'headerOptions' => ['style' => 'width: 114px;'],
                ],
                [
                    'attribute' => 'Дата посл. переделки',
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->getRedoneDates();
                    },
                    'headerOptions' => ['style' => 'width: 85px; white-space: break-spaces'],
                ],
                [
                    'attribute' => 'prepaid',
                    'contentOptions' => ['class' => 'fix-row-min'],
                ],
                [
                    'attribute' => 'cost',
                    'contentOptions' => ['class' => 'fix-row-min'],
                ],
                [
                    'attribute' => 'status_id',
                    'format' => 'raw',
                    //'contentOptions' => ['class' => 'fix-row-min'],
                    'value' => function ($data) {
                        return $data->status_id ? $data->statusName.'<br>'.$data->lastChangeStatus() : '-';
                    },
                    'filter' => Order::statusNamesArray(),
                    'filterInputOptions' => ['class' => 'form-control search-status', 'data-id' => $model->id],
                ],
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
</div>
<?php
echo $this->render('print-links/default');
echo Html::a('Печать', null, ['class' => 'btn btn-primary print', 'data-id' => 'all']);
?>
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
        select option[value="<?= $k ?>"] {
            <?= $v ?>
        }
    <?php endforeach; ?>
</style>
