<?php

use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\directory\models\Shoes;
use app\modules\directory\models\ShoesMaterial;
use app\modules\directory\models\ShoesLining;
use app\modules\directory\models\ShoesSole;
use app\modules\directory\models\AgeGroup;
use app\modules\directory\models\ShoesColor;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\ShoesBrand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shoes-brand-form">

    <?php $form = ActiveForm::begin(['id' => 'form-shoes-brand', 'options' => ['data-id' => $model->id]]); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Свойства модели
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'shoes_id')->dropDownList(Shoes::getList(), ['prompt' => '[Не выбрано]']) ?>

                    <?= $form->field($model, 'age_group_id')->widget(Select2::classname(), [
                        'data' => AgeGroup::getList(),
                        'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
                        'showToggleAll' => false,
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>

                    <?= $form->field($model, 'lining_id')->widget(Select2::classname(), [
                        'data' => ShoesLining::getList(),
                        'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
                        'showToggleAll' => false,
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>

                    <?= $form->field($model, 'sole_id')->widget(Select2::classname(), [
                        'data' => ShoesSole::getList(),
                        'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
                        'showToggleAll' => false,
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>

                    <?= $form->field($model, 'material_id')->widget(Select2::classname(), [
                        'data' => ShoesMaterial::getList(),
                        'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
                        'showToggleAll' => false,
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Цвета
                </div>
                <div class="panel-body">
                    <div id="brand-colors">
                        <?= $this->render('_colors_form', [
                            'model' => $model,
                            'materialIds' => $model->material_id
                        ]) ?>
                    </div>
                        <?php if($model->color_ids) : ?>
                            <div class="form-group">
                                <?= Html::a('Редактировать изображения', ['shoes-brand/images', 'id' => $model->id], ['target' => '_blanc']) ?>
                            </div>
                        <?php else : ?>
                            <div class="form-group">
                                Для загрузки изображений модели выберите цвета
                            </div>
                        <?php endif; ?>


                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Свойства страницы
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'short_description')->widget(Summernote::class, [
                        'autoFormatCode' => false,
                    ]) ?>
                    <?= $form->field($model, 'description')->widget(Summernote::class, [
                        'autoFormatCode' => false,
                    ]) ?>
                    <?= $form->field($model, 'meta_description')->widget(Summernote::class, [
                        'autoFormatCode' => false,
                    ]) ?>
                </div>
            </div>
        </div>

    </div>



    <?/*= $this->render('_brand_images', [
        'form' => $form,
        'model' => $model,
    ])*/ ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
