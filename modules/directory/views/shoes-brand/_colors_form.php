<?php

use app\modules\directory\models\ShoesColor;
use kartik\select2\Select2;
use yii\helpers\Html;
use app\modules\directory\models\ShoesMaterial;

?>
<?php if($materialIds) : ?>
<table class="table table-colors-list">
<?php foreach($materialIds as $materialId) : ?>
    <?php
        $material = ShoesMaterial::findOne($materialId);
        /*echo "<pre>";
        print_r($model);
        echo "</pre>";
        exit;*/
    ?>
    <tr>
        <td colspan="2">
            <?php if($material) echo "<label class='control-label'>Цвет для материала  {$material->name}</label>"; ?>
        </td>
    </tr>
    <tr class="form-group">

        <td>
            <?=
            $material ? Select2::widget([
                'model' => $model,
                'attribute' => "color_ids[{$materialId}]",
                'data' => $material->getColorsList(),
                'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
                'showToggleAll' => false,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) : null
            ?>
            <?/*= $form->field($model, "color_ids[{$material->id}]")->widget(Select2::classname(), [
            'data' => ShoesColor::getList(),
            'options' => ['placeholder' => '[не выбраны]', 'multiple' => true],
            'showToggleAll' => false,
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->label('Цвет для материала '.$material->name)*/ ?>
        </td>
        <td>
            <?php
                $linkTitle = 'Изображения';
                if($count = $model->brandMaterialsCount($materialId)) {
                    $linkTitle .= ' ('.$count.')';
                }
            ?>
            <?= Html::a($linkTitle, ['shoes-brand/material-images', 'brand_id' => $model->id, 'material_id' => $materialId], ['class' => 'btn btn-xs btn-primary', 'target' => '_blanc']) ?>
        </td>

    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
<style>
    .table.table-colors-list tr td {
        vertical-align: middle;
        border: none;
    }
</style>
