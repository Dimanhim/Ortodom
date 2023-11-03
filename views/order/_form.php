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

    <?php echo $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map(Payment::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>

    <?php echo  $form->field($model, 'patient_id')->widget(Widget::className(), [
        'options' => [
            'multiple' => false,
            'placeholder' => 'Выбрать',
        ],
        'settings' => [
            'width' => '100%',
        ],
        'items' => ArrayHelper::map(Patient::find()->orderBy('full_name')->asArray()->all(), 'id', 'full_name'),
    ]); ?>

    <?php echo $form->field($model, 'representative_name')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'referral')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'model')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'color')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'size')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'block')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'shoes_id')->dropDownList(ArrayHelper::map(Shoes::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>

    <?php echo $form->field($model, 'diagnosis_id')->dropDownList(ArrayHelper::map(Diagnosis::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Выбрать']); ?>

    <?php //echo $form->field($model, 'appointment_left_id')->dropDownList($model->appointmentLeftArray(), ['prompt' => 'Выбрать']); ?>
    <?php //echo $form->field($model, 'appointment_right_id')->dropDownList($model->appointmentRightArray(), ['prompt' => 'Выбрать']); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'appointment_left')->textarea(); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'appointment_right')->textarea(); ?>
        </div>
    </div>
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
    <?php
        $params = [
            'style' => $model->statusStyle,
            'options' => $model->disabledStatuses,
        ];
    ?>
    <?= $form->field($model, 'status_id')->dropDownList(Order::getOrderStatusesArray(), $params) ?>

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

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
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
