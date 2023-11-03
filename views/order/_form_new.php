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
                    <?php echo $form->field($model, 'representative_name')->textInput(['maxlength' => true]); ?>
                    <?php echo $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map(Payment::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                    <?php echo $form->field($model, 'referral')->textInput(['maxlength' => true]); ?>
                    <?php echo $form->field($model, 'diagnosis_id')->dropDownList(ArrayHelper::map(Diagnosis::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo $form->field($model, 'shoes_id')->dropDownList(ArrayHelper::map(Shoes::find()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>
                    <?php echo $form->field($model, 'shoes_data')->textInput(['maxlength' => true])->label(false) ?>
                    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
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
                        'style' => $model->statusStyle,
                        'options' => $model->disabledStatuses,
                        'prompt' => '--Выбрать--',
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
JS;

$this->registerJs($js);
?>
