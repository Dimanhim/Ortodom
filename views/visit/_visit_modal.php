<?php
use app\components\Calendar;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Patient;
?>
<div class="modal" id="show-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-date="<?= $model->visit_date ?>" data-id="<?= $model->id ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="form">
                    <div style="padding: 10px 0; font-size:18px">
                        Запись на прием <b><span id="date-value"><?= $model->visit_date ?></span> в <span id="time-value"><?= $model->visit_time ?></span></b>
                    </div>

                    <?php $form = ActiveForm::begin(['id' => 'form-visit-modal', 'action' => '/visit/save-modal', 'options' => ['class' => 'marked']]) ?>
                    <?//= $form->field($model, 'patient_id')->dropDownList(ArrayHelper::map(Patient::find()->all(), 'id', 'full_name'), ['prompt' => '--Выбрать--', 'required' => 'required', 'class' => 'form-control chosen']) ?>
                    <?= $form->field($model, 'patient_id', ['template' => '{input}'])->hiddenInput(['value' => $model->patient_id]) ?>
                    <!--
                    <div class="form-group">
                        <b><a href="#" id="visit-create-client">или создайте нового</a></b>
                    </div>
                    -->
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['required' => 'required']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone')->textInput(['class' => 'form-control phone-mask', 'required' => 'required']) ?>
                        </div>
                    </div>
                    <!--
                    <div class="row">
                        <div class="col-md-6">
                            <?//= $form->field($model, 'address')->textInput(['readonly' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?//= $form->field($model, 'birthday')->textInput(['class' => 'form-control date-picker', 'readonly' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?//= $form->field($model, 'passport_data')->textarea(['readonly' => true]) ?>
                        </div>
                    </div>
                    -->
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'visit_date')->textInput(['class' => 'form-control date-picker']) ?>
                        </div>
                        <div class="col-md-6">
                            <?//= $form->field($model, 'visit_time')->textInput(['class' => 'form-control select-time']) ?>
                            <?//= $form->field($model, 'visit_time')->dropDownList($calendar->workTimeArray) ?>
                            <?= $form->field($model, 'visit_time')->dropDownList([]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="error"></p>
                    </div>
                    <?php if(!Yii::$app->user->isGuest) : ?>
                    <div class="form-group row">
                        <div class="col-md-3"><?= $form->field($model, 'reserved')->checkbox() ?></div>
                        <div class="col-md-3"><?= $form->field($model, 'is_insoles')->checkbox() ?></div>
                        <div class="col-md-3"><?= $form->field($model, 'is_children')->checkbox() ?></div>
                        <div class="col-md-3"><?= $form->field($model, 'is_fitting')->checkbox() ?></div>
                    </div>
                    <div class="">




                    </div>
                    <?php endif; ?>
                    <?//= $form->field($model, 'visit_date', ['template' => '{input}'])->hiddenInput() ?>
                    <?//= $form->field($model, 'visit_time', ['template' => '{input}'])->hiddenInput() ?>
                    <?= $form->field($model, 'model_id', ['template' => '{input}'])->hiddenInput(['value' => $model->id]) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= Html::submitButton('Сохранить', ['class' => "btn btn-success"]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $model->id ? Html::a('Удалить', Yii::$app->urlManager->createUrl(['visit/delete', 'id' => $model->id]), ['class' => 'btn btn-danger pull-right', 'data-confirm' => 'Вы действительно хотите удалить запись?']) : '' ?>
                        </div>
                    </div>

                    <?php ActiveForm::end() ?>

                </div>
            </div>
        </div>
    </div>
</div>

