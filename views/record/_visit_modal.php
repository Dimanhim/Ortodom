<?php
use app\components\Calendar;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Patient;
?>
<div class="modal" id="show-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-date="<?= $model->visit_date ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="form">
                    <div style="padding: 10px 0; font-size:18px">
                        Запись на прием <b><span id="date-value"><?= $model->visit_date ?></span> в <span id="time-value"><?= $model->visit_time ?></span></b>
                    </div>

                    <?php $form = ActiveForm::begin(['id' => 'form-visit-modal', 'action' => '/record/save-modal', 'options' => ['class' => 'marked']]) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['required' => 'required']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone')->textInput(['class' => 'form-control phone-mask', 'required' => 'required']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'visit_date')->textInput(['class' => 'form-control date-picker']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'visit_time')->dropDownList([]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>
                            ВНИМАНИЕ!
                        </p>
                        <p>
                            Для подтверждения вашей записи ожидайте SMS уведомления на ваш контактный номер! В случае отсутствии SMS уведомления в течении 3 минут просьба обратиться к нам в контактный центр для уточнения актуальности вашей записи по единому справочному телефону : +7(812)934-4554. Только после получения SMS или подтверждения по телефону Ваша запись будет являться актуальной!
                        </p>
                    </div>
                    <div class="form-group">
                        <table>
                            <tr>
                                <td style="width: 30px; vertical-align: top">
                                    <input type="checkbox" id="personal-legacy" required>
                                </td>
                                <td style="vertical-align: middle">
                                    <label for="personal-legacy">
                                        Даю согласие на обработку персональных данных
                                        и соглашаюсь с условиями записи на прием
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <p class="error"></p>
                    </div>
                    <?= $form->field($model, 'model_id', ['template' => '{input}'])->hiddenInput(['value' => $model->id]) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= Html::submitButton('Сохранить', ['class' => "btn btn-success"]) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end() ?>

                </div>
            </div>
        </div>
    </div>
</div>

