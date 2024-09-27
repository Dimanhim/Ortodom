<?php
use app\models\Patient;
//use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */
/* @var $form yii\widgets\ActiveForm */

//create new record for getting id (need for representative form correct work)
if ($model->isNewRecord) {   
    $model->full_name = NULL;
    $model->birthday = "-";
    $model->address = NULL;
    $model->phone = NULL;       
    $model->passport_data = "-"; 

    $model->save($runValidation = false,$insert_order = true); 
    $model->passport_data = NULL;
    $model->birthday = NULL;
}
$formActionUrl = "/patient/update?id=" . $model["id"]; //change url for update, not create
?>

<div class="patient-form">

    <?php $form = ActiveForm::begin(['action' => $formActionUrl]); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Основная информация
                </div>
                <div class="panel-body">                    
                    <?php echo $form->field($model, 'full_name')->textInput(['maxlength' => true]); ?>

                    <?php echo $form->field($model, 'birthday')->widget(
                        DatePicker::className(), [
                        'inline' => false,
                        'dateFormat' => 'dd.MM.yyyy',
                        'language' => 'ru',
                        'options' => [
                            'class' => 'form-control date-time-widget',
                        ],
                    ]); ?>

                    <?= $form->field($model, 'address')->widget(
                        AutoComplete::className(), [
                        'clientOptions' => [
                            'source' => Url::to(['streets']),
                            'minLength'=>'2',
                        ],
                        'options'=>[
                            'class'=>'form-control'
                        ]
                    ]) ?>

                    <?php echo $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'form-control phone-mask']); ?>

                    <div class="hidden-field">
                        <?php echo $form->field($model, 'created_at')->textInput(['rows' => 1]); ?> 
                    </div>

                    <?php echo $form->field($model, 'passport_data')->textarea(['rows' => 2]); ?>

                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $form->field($model, 'problem')->checkbox(); ?>
                        </div>
                        <div class="col-md-10" id="patient-problem_data-container">
                            <?php echo $form->field($model, 'problem_data')->textarea(['rows' => 2]); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Представители
                </div>
                <div class="panel-body">
                    <?= $this->render('_representative_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'button-main']);
         ?>
    </div>
    <?php ActiveForm::end();
    //var_dump($model);  ?>

</div>
<style>
    .hidden-field { display:none }
    .representative-edit {
        background: #f5f5f5;
        border: 1px solid #ddd;
        padding: 10px;
    }
    .representative-edit h2 {
        font-size: 18px;
    }
</style>


<?php
$js = <<<JS
    
    //покрасить зеленым поля ввода, если заполнены
    const inputColorIfFilled = '#e6f6c7';

    //ФИО       
    $('#patient-full_name').on('change', function() {
        if($("#patient-full_name").val() != "") {
            $('#patient-full_name').css('background', inputColorIfFilled);
        } else {
            $('#patient-full_name').css('background', 'none');
        }
    });

    //Дата рождения       
     $('#patient-birthday').on('change', function() {
        if($("#patient-birthday").val() != "") {
            $('#patient-birthday').css('background', inputColorIfFilled);
        } else {
            $('#patient-birthday').css('background', 'none');
        }
    });

    //Адрес       
     $('#patient-address').on('change', function() {
        if($("#patient-address").val() != "") {
            $('#patient-address').css('background', inputColorIfFilled);
        } else {
            $('#patient-address').css('background', 'none');
        }
    });

    //Телефон       
    $('#patient-phone').on('change', function() {
        if($("#patient-phone").val() != "") {
            $('#patient-phone').css('background', inputColorIfFilled);
        } else {
            $('#patient-phone').css('background', 'none');
        }
    });

    //Паспортные данные пациента       
    $('#patient-passport_data').on('change', function() {
        if($("#patient-passport_data").val() != "") {
            $('#patient-passport_data').css('background', inputColorIfFilled);
        } else {
            $('#patient-passport_data').css('background', 'none');
        }
    });

    //ФИО представителя 
    document.addEventListener("change", function() {
    if (document.querySelector('[name="PatientRepresentative[name]"]')) {
        let innerText = $('[name="PatientRepresentative[name]"]');
        let selected = innerText.val();

        if(selected != "") {
            innerText.css('background', inputColorIfFilled);
        } else {
            innerText.css('background', 'none');
        }
    }
    }, false);
    

    //Паспортные данные представителя 
    document.addEventListener("change", function() {
    if (document.querySelector('[name="PatientRepresentative[passport_data]"]')) {
        let innerText = $('[name="PatientRepresentative[passport_data]"]');
        let selected = innerText.val();

        if(selected != "") {
            innerText.css('background', inputColorIfFilled);
        } else {
            innerText.css('background', 'none');
        }
    }
    }, false);        
JS;

$this->registerJs($js);
?>
