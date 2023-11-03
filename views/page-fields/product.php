<?php

use app\models\ContentPage;
use himiklab\thumbnail\EasyThumbnailImage;
use kartik\widgets\FileInput;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\editors\Summernote;
use app\models\Config;
use app\modules\directory\models\ShoesBrand;

/* @var $model ContentPage */
/* @var $form ActiveForm */
?>

<?= $form->field($model, 'brand_id')->dropDownList(ShoesBrand::getList(), ['prompt' => '[Не выбрано]', 'class' => 'form-control chosen']) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control page-name']) ?>





