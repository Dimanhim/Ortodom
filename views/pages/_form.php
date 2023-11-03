<?php

use app\models\Page;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Mentor;

/* @var $this yii\web\View */
/* @var $page common\models\Page */
/* @var $model object */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-7">
                <?= $this->render("/page-fields/{$page->type}", [
                    'model' => $model,
                    'form' => $form,
                ]) ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($page, 'alias')->textInput(['maxlength' => true]) ?>
                <?/*= $form->field($page, 'parent_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Page::getList($page->type), 'id', 'name'),
                    'options' => ['placeholder' => 'Не указан'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])*/ ?>
                <?= $form->field($page, 'parent_id')->dropDownList(ArrayHelper::map(Page::getAgeList($page->type), 'id', 'name'), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>
                <?= $form->field($page, 'name')->textInput(['maxlength' => true, 'class' => 'form-control page-name']) ?>
                <?= $form->field($page, 'h1')->textInput(['maxlength' => true]) ?>
                <?= $form->field($page, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($page, 'meta_description')->textInput(['maxlength' => true]) ?>
                <?= $form->field($page, 'meta_keywords')->textInput(['maxlength' => true]) ?>
                <?= $form->field($page, 'template')->textInput(['maxlength' => true]) ?>
                <?= $form->field($page, 'external_link')->textInput(['maxlength' => true]) ?>
                <?= $form->field($page, 'custom_code')->textarea(['rows' => 10]) ?>
                <?= $form->field($page, 'search_indexing')->checkbox() ?>
                <?= $form->field($page, 'sortOrder')->textInput(['maxlength' => true]) ?>
                <?= $form->field($page, 'is_active')->checkbox() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?php if (!$page->isNewRecord): ?>
                <?= Html::a('Перейти', $page->getFullUri(), ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
            <?php endif ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
