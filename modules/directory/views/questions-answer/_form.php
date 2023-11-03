<?php

use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\QuestionsAnswer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question')->widget(Summernote::class, [
        'autoFormatCode' => false,
    ]) ?>
    <?= $form->field($model, 'answer')->widget(Summernote::class, [
        'autoFormatCode' => false,
    ]) ?>
    <?= $form->field($model, 'sortOrder')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
