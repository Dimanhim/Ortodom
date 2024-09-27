<?php

use app\models\Order;
use app\models\Patient;
use app\modules\directory\models\Diagnosis;
use app\modules\directory\models\Payment;
use app\modules\directory\models\Shoes;
use dosamigos\datepicker\DatePicker;
use vova07\select2\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php /*echo  $form->field($model, 'patient_id')->widget(Widget::className(), [
                        'options' => [
                            'multiple' => false,
                            'placeholder' => 'Выбрать',
                        ],
                        'settings' => [
                            'width' => '100%',
                        ],
                        'items' => ArrayHelper::map(Patient::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'),
                    ]);*/ ?>
                    <?= $form->field($model, 'patient_id')->dropDownList(ArrayHelper::map(Patient::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'), ['prompt' => '--Выбрать--', 'class' => 'form-control chosen']) ?>
                    <div class="form-group">
                        <?= Html::a('Создать нового пациента', ['/patient/create', 'from' => 'order'], ['class' => 'btn btn-success', 'style' => 'margin-top: 16px']) ?>
                    </div>
                    <div id="representative-field">
                        <?php if($model->patient) echo $form->field($model, 'representative_id')->dropDownList($model->patient->getRepresentativeList(), ['prompt' => '[Не выбрано]']) ?>
                    </div>

                    <?php //echo $form->field($model, 'representative_name')->textInput(['maxlength' => true]); ?>
                    <?php //echo $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map(Payment::find()->where(['NOT IN', 'id', [4,14,9,10,11,8,7]])->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                    <?php echo $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map(Payment::find()->where(['NOT IN', 'showInSelectList', [0]])->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                    <?php //echo $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map(Payment::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                    <?php echo $form->field($model, 'referral')->textInput(['maxlength' => true]); ?>
                    <?php echo $form->field($model, 'diagnosis_id')->dropDownList(ArrayHelper::map(Diagnosis::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo $form->field($model, 'shoes_id')->dropDownList(ArrayHelper::map(Shoes::find()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                    <?php echo $form->field($model, 'shoes_data')->textInput(['maxlength' => true])->label(false) ?>
                    <?//= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'brand_id')->dropDownList($model->brandList, ['prompt' => 'Выбрать']) ?>
                    <?= $form->field($model, 'brand_data')->textInput(['maxlength' => true])->label(false) ?>
                    <?= $form->field($model, 'lining_id')->dropDownList($model->liningList, ['prompt' => 'Выбрать']) ?>
                    <?= $form->field($model, 'lining_data')->textInput(['maxlength' => true])->label(false) ?>
                    <?= $form->field($model, 'material_id')->dropDownList($model->materialList, ['prompt' => 'Выбрать']) ?>
                    <?= $form->field($model, 'material_data')->textInput(['maxlength' => true])->label(false) ?>
                    <?= $form->field($model, 'color_id')->dropDownList($model->colorList, ['prompt' => 'Выбрать']) ?>
                    <?= $form->field($model, 'color_data')->textInput(['maxlength' => true])->label(false) ?>
                    <?= $form->field($model, 'sole_id')->dropDownList($model->soleList, ['prompt' => 'Выбрать']) ?>
                    <?php echo $form->field($model, 'sole_data')->textInput(['maxlength' => true])->label(false); ?>
                    <?= $form->field($model, 'last_id')->dropDownList($model->lastList, ['prompt' => 'Выбрать']) ?>
                    <?php echo $form->field($model, 'last_data')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-order-form">
                        <tr>
                            <td class="table-order-left">
                                <?php echo $form->field($model, 'appointment_left')->dropDownList($model->appointmentArray(), ['prompt' => 'Выбрать']) ?>
                            </td>
                            <td class="table-order-arrow table-order-arrow-full">
                                <a href="#" class="arrow-left arrow-select">
                                    <span class="glyphicon glyphicon-arrow-left"></span>
                                </a>
                            </td>
                            <td class="table-order-arrow table-order-arrow-full">
                                <a href="#" class="arrow-right arrow-select">
                                    <span class="glyphicon glyphicon-arrow-right"></span>
                                </a>
                            </td>
                            <td class="table-order-right">
                                <?php echo $form->field($model, 'appointment_right')->dropDownList($model->appointmentArray(), ['prompt' => 'Выбрать']) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-order-left">
                                <?php echo $form->field($model, 'appointment_left_data')->textInput(['maxlength' => true])->label(false); ?>
                            </td>
                            <td class="table-order-arrow table-order-arrow-short">
                                <a href="#" class="arrow-left arrow-input">
                                    <span class="glyphicon glyphicon-arrow-left"></span>
                                </a>
                            </td>
                            <td class="table-order-arrow table-order-arrow-short">
                                <a href="#" class="arrow-right arrow-input">
                                    <span class="glyphicon glyphicon-arrow-right"></span>
                                </a>
                            </td>
                            <td class="table-order-right">
                                <?php echo $form->field($model, 'appointment_right_data')->textInput(['maxlength' => true])->label(false); ?>
                            </td>
                        </tr>
                        <!--
                        <tr>
                            <td class="table-order-left">
                                <?php //echo $form->field($model, 'heel_left')->dropDownList($model->heelArray(), ['prompt' => 'Выбрать']) ?>
                            </td>
                            <td class="table-order-arrow table-order-arrow-full">
                                <a href="#" class="arrow-left arrow-select">
                                    <span class="glyphicon glyphicon-arrow-left"></span>
                                </a>
                            </td>
                            <td class="table-order-arrow table-order-arrow-full">
                                <a href="#" class="arrow-right arrow-select">
                                    <span class="glyphicon glyphicon-arrow-right"></span>
                                </a>
                            </td>
                            <td class="table-order-right">
                                <?php //echo $form->field($model, 'heel_right')->dropDownList($model->heelArray(), ['prompt' => 'Выбрать']) ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="table-order-left">
                                <?php //echo $form->field($model, 'heel_left_data')->textInput(['maxlength' => true])->label(false); ?>
                            </td>
                            <td class="table-order-arrow table-order-arrow-short">
                                <a href="#" class="arrow-left arrow-input">
                                    <span class="glyphicon glyphicon-arrow-left"></span>
                                </a>
                            </td>
                            <td class="table-order-arrow table-order-arrow-short">
                                <a href="#" class="arrow-right arrow-input">
                                    <span class="glyphicon glyphicon-arrow-right"></span>
                                </a>
                            </td>
                            <td class="table-order-right">
                                <?php //echo $form->field($model, 'heel_right_data')->textInput(['maxlength' => true])->label(false); ?>
                            </td>
                        </tr>
                        -->
                    </table>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'need_fitting')->checkbox() ?>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo $form->field($model, 'accepted')->widget(
                        DatePicker::className(), [
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                        ],
                        'language' => 'ru',
                    ]); ?>
                    <?php echo $form->field($model, 'issued')->widget(
                        DatePicker::className(), [
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                        ],
                        'language' => 'ru',
                    ]); ?>
                    <?= $form->field($model, 'file')->fileInput() ?>
                    <?php if($model->scan) : ?>
                        <div class="scan-file">
                            <img src="/images/scan/<?= $model->scan ?>" alt="" class="img-file" width="200" />
                            <div style="margin-top: 10px;">
                                <a href="#" class="btn-delete" data-id="<?= $model->id ?>" style="margin-left: 10px;">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                                <a href="<?//= Yii::$app->urlManager->createUrl(['order/index']) ?><?= Yii::$app->urlManager->createAbsoluteUrl(['/images/scan/'.$model->scan]) ?>" class="buttonPrint" style="margin-left: 20px;">
                                    <img src="/images/leg-icon.png" class="leg-icon leg-icon-form" alt="">
                                    <!--<i class="glyphicon glyphicon-print"></i>-->
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php echo $form->field($model, 'prepaid')->textInput(['maxlength' => true]); ?>
                    <?php echo $form->field($model, 'cost')->textInput(['maxlength' => true]); ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    $params = [
                        /*'style' => $model->statusStyle,*/
                        'options' => $model->disabledStatuses,
                        'prompt' => '--Выбрать--',
                        'style' => 'background: rgb(230, 246, 199);',
                    ];
                    ?>
                    <?= $form->field($model, 'status_id')->dropDownList(Order::getOrderStatusesArray(), $params) ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Фото модели итоговой
                </div>
                <div class="panel-body">
                    <?= $model->modelImageBlock() ?>
                </div>
            </div>

            <?php
                $reviewShowClass = $model->issued ? ' showed' : ''
            ?>
            <!--
            <div class="panel panel-default sms-yandex-review<?= $reviewShowClass ?>">
                <div class="panel-body">
                    <?//= $form->field($model, 'sms_yandex_review')->checkbox() ?>
                </div>
            </div>
            -->
            <div class="panel panel-default sms-yandex-review<?= $reviewShowClass ?>">
                <div class="panel-body">
                    <div class="form-group">
                        <?= $form->field($model, 'sms_yandex_review')->radioList([
                            Order::YANDEX_REVIEW_SMS_SEND_YES => 'Да',
                            Order::YANDEX_REVIEW_SMS_SEND_NO => 'Нет',
                        ], ['class' => 'review-radio-btns', 'required' => true]) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить заказ' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>






<?php
$paymentId = Html::getInputId($model, 'payment_id');
$prepaidId = Html::getInputId($model, 'prepaid');
$costId = Html::getInputId($model, 'cost');
$js = <<<JS
    $('#{$paymentId}').on('change', function() {
        var payment = $(this).val();
        $('#{$prepaidId}').closest('div').css('display', payment == 3 || payment == 4 || payment == 6 ? 'block' : 'none');
        $('#{$costId}').closest('div').css('display', payment == 3 || payment == 4 || payment == 6 ? 'block' : 'none');
    });
    $('#{$paymentId}').trigger('change');


    //покрасить зеленым поля ввода, если заполнены
    const inputColorIfFilled = '#e6f6c7';

    //ФИО
    $('#order-patient_id').on('change', function() {
        if($('#order-patient_id option:selected').text() != '--Выбрать--') {
            $('#order_patient_id_chosen').css('background', inputColorIfFilled);
        } else {
            $('#order_patient_id_chosen').css('background', 'none');
        }
    });

    //Представитель
    document.addEventListener("change", function() {
    if (document.querySelector('[name="Order[representative_id]"]')) {
        let innerText = $('[name="Order[representative_id]"]');
        let selected = innerText.val();

        if(selected != "") {
            innerText.css('background', inputColorIfFilled);
        } else {
            innerText.css('background', 'none');
        }
    }
    }, false);
    
    //Форма оплаты
    $('#order-payment_id').on('change', function() {
        if($('#order-payment_id option:selected').text() != 'Выбрать') {
            $('#order-payment_id').css('background', inputColorIfFilled);
        } else {
            $('#order-payment_id').css('background', 'none');
        }
    });

    //№ и дата направления
    $('#order-referral').on('change', function() {
        if($("#order-referral").val() != "") {
            $('#order-referral').css('background', inputColorIfFilled);
        } else {
            $('#order-referral').css('background', 'none');
        }
    });
    
    //Диагноз
    $('#order-diagnosis_id').on('change', function() {
        if($('#order-diagnosis_id option:selected').text() != 'Выбрать') {
            $('#order-diagnosis_id').css('background', inputColorIfFilled);
        } else {
            $('#order-diagnosis_id').css('background', 'none');
        }
    });

    //Вид обуви
    $('#order-shoes_id').on('change', function() {
        if($('#order-shoes_id option:selected').text() != 'Выбрать') {
            $('#order-shoes_id').css('background', inputColorIfFilled);
        } else {
            $('#order-shoes_id').css('background', 'none');
        }        
    });

    //Вид обуви - поле
    $('#order-shoes_data').on('change', function() {
        if($("#order-shoes_data").val() != "") {
            $('#order-shoes_data').css('background', inputColorIfFilled);
        } else {
            $('#order-shoes_data').css('background', 'none');
        }
    });

    //Модель
    $('#order-brand_id').on('change', function() {
        if($('#order-brand_id option:selected').text() != 'Выбрать') {
            $('#order-brand_id').css('background', inputColorIfFilled);
        } else {
            $('#order-brand_id').css('background', 'none');
        }        
    });

    //Модель - поле
    $('#order-brand_data').on('change', function() {
        if($("#order-brand_data").val() != "") {
            $('#order-brand_data').css('background', inputColorIfFilled);
        } else {
            $('#order-brand_data').css('background', 'none');
        }
    });

    //Подкладка
    $('#order-lining_id').on('change', function() {
        if($('#order-lining_id option:selected').text() != 'Выбрать') {
            $('#order-lining_id').css('background', inputColorIfFilled);
        } else {
            $('#order-lining_id').css('background', 'none');
        }        
    });

    //Подкладка - поле
    $('#order-lining_data').on('change', function() {
        if($("#order-lining_data").val() != "") {
            $('#order-lining_data').css('background', inputColorIfFilled);
        } else {
            $('#order-lining_data').css('background', 'none');
        }
    });

    //Материал верха/цвет
    $('#order-material_id').on('change', function() {
        if($('#order-material_id option:selected').text() != 'Выбрать') {
            $('#order-material_id').css('background', inputColorIfFilled);
        } else {
            $('#order-material_id').css('background', 'none');
        }        
    });

    //Материал верха/цвет - поле
    $('#order-material_data').on('change', function() {
        if($("#order-material_data").val() != "") {
            $('#order-material_data').css('background', inputColorIfFilled);
        } else {
            $('#order-material_data').css('background', 'none');
        }
    });

    //Цвет
    $('#order-color_id').on('change', function() {
        if($('#order-color_id option:selected').text() != 'Выбрать') {
            $('#order-color_id').css('background', inputColorIfFilled);
        } else {
            $('#order-color_id').css('background', 'none');
        }        
    });

    //Цвет - поле
    $('#order-color_data').on('change', function() {
        if($("#order-color_data").val() != "") {
            $('#order-color_data').css('background', inputColorIfFilled);
        } else {
            $('#order-color_data').css('background', 'none');
        }
    });

    //Подошва
    $('#order-sole_id').on('change', function() {
        if($('#order-sole_id option:selected').text() != 'Выбрать') {
            $('#order-sole_id').css('background', inputColorIfFilled);
        } else {
            $('#order-sole_id').css('background', 'none');
        }        
    });

    //Подошва - поле
    $('#order-sole_data').on('change', function() {
        if($("#order-sole_data").val() != "") {
            $('#order-sole_data').css('background', inputColorIfFilled);
        } else {
            $('#order-sole_data').css('background', 'none');
        }
    });

    //Колодка
    $('#order-last_id').on('change', function() {
        if($('#order-last_id option:selected').text() != 'Выбрать') {
            $('#order-last_id').css('background', inputColorIfFilled);
        } else {
            $('#order-last_id').css('background', 'none');
        }        
    });

    //Колодка - поле
    $('#order-last_data').on('change', function() {
        if($("#order-last_data").val() != "") {
            $('#order-last_data').css('background', inputColorIfFilled);
        } else {
            $('#order-last_data').css('background', 'none');
        }
    });

    //Назначение левая
    $('#order-appointment_left').on('input', function() {
        if($('#order-appointment_left option:selected').text() != 'Выбрать') {
            $('#order-appointment_left').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_left').css('background', 'none');
        }        
    });

    //Назначение левая - стрелка вправо
    $('.arrow-right.arrow-select').on('click', function() {
        if($('#order-appointment_left option:selected').text() != 'Выбрать') {
            $('#order-appointment_right').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_right').css('background', 'none');
        }        
    });

    //Назначение левая - поле
    $('#order-appointment_left_data').on('input', function() {
        if($("#order-appointment_left_data").val() != "") {
            $('#order-appointment_left_data').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_left_data').css('background', 'none');
        }
    });

    //Назначение левая - поле - стрелка вправо
    $('.arrow-right.arrow-input').on('click', function() {
        if($("#order-appointment_left_data").val() != "") {
            $('#order-appointment_right_data').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_right_data').css('background', 'none');
        }       
    });

    //Назначение правая
    $('#order-appointment_right').on('input', function() {
        if($('#order-appointment_right option:selected').text() != 'Выбрать') {
            $('#order-appointment_right').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_right').css('background', 'none');
        }        
    });

    //Назначение правая - стрелка влево
        $('.arrow-left.arrow-select').on('click', function() {
        if($('#order-appointment_right option:selected').text() != 'Выбрать') {
            $('#order-appointment_left').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_left').css('background', 'none');
        }        
    });

    //Назначение правая - поле
    $('#order-appointment_right_data').on('input', function() {
        if($("#order-appointment_right_data").val() != "") {
            $('#order-appointment_right_data').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_right_data').css('background', 'none');
        }
    });

    //Назначение правая - поле - стрелка влево
    $('.arrow-left.arrow-input').on('click', function() {
        if($("#order-appointment_right_data").val() != "") {
            $('#order-appointment_left_data').css('background', inputColorIfFilled);
        } else {
            $('#order-appointment_left_data').css('background', 'none');
        }       
    });

    //Принят
     $('#order-accepted').on('change', function() {
        if($("#order-accepted").val() != "") {
            $('#order-accepted').css('background', inputColorIfFilled);
        } else {
            $('#order-accepted').css('background', 'none');
        }
    });

    //Выдан
     $('#order-issued').on('change', function() {
        if($("#order-issued").val() != "") {
            $('#order-issued').css('background', inputColorIfFilled);
        } else {
            $('#order-issued').css('background', 'none');
        }
    });

    //Аванс
    $('#order-prepaid').on('change', function() {
        if($("#order-prepaid").val() != "") {
            $('#order-prepaid').css('background', inputColorIfFilled);
        } else {
            $('#order-prepaid').css('background', 'none');
        }
    });

    //Стоимость
    $('#order-cost').on('change', function() {
        if($("#order-cost").val() != "") {
            $('#order-cost').css('background', inputColorIfFilled);
        } else {
            $('#order-cost').css('background', 'none');
        }
    });

    //Статус
    $('#order-status_id').on('change', function() {
        if($('#order-status_id option:selected').text() != '--Выбрать--') {
            $('#order-status_id').css('background', inputColorIfFilled);
        } else {
            $('#order-status_id').css('background', 'none');
        }
    });
   
JS;

$this->registerJs($js);
?>
