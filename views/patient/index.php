<?php

use app\models\Patient;
use dosamigos\datepicker\DatePicker;
//use yii\jui\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пациенты';
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->user->getIdentity()->role;
?>
<div class="patient-index">

    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p class="text-right">
        <?php echo Html::a('Новый пациент', ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-3">
            <?php $form = ActiveForm::begin(['method' => 'get','fieldConfig' => ['options' => ['tag' => false]]]) ?>
            <?php
                if(Yii::$app->request->get('PaymentForm')) {
                    $payment = Yii::$app->request->get('PaymentForm')['payment'];
                } else {
                    $payment = '';
                }
                $params = [
                    'prompt' => '--Выбрать--',
                    'onchange' => 'this.form.submit()',
                    'options' => [
                        $payment => ['selected' => true],
                    ]
                ]
            ?>
            <?= $form->field($model, 'payment')->dropDownlist($items, $params) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <?php
        if(Yii::$app->request->get('PaymentForm')) {
            $payment = Yii::$app->request->get('PaymentForm')['payment'];
        } else {
            $payment = 0;
        }
    ?>
    <?php if(Yii::$app->user->getIdentity()->role == 'superadmin') : ?>
    <p class="text-right">
        <?php echo Html::a('В Excel', [Yii::$app->urlManager->createUrl(['patient/excel', 'payment' => $payment])], ['class' => 'btn btn-success']); ?>
    </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'full_name',
                    'value' => function($data) {
                        return $data->fullName;
                    }
                ],
                [
                    'attribute' => 'birthday',
                    'value' => 'birthday',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'birthday',
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
                'address',
                'phone',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {newOrder}',
                    'buttons' => [
                        'newOrder' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/order/create', 'patient_id' => $model->id]);
                        },
                    ],
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
