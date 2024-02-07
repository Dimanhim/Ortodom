<?php

use yii\helpers\Html;

?>
<div class="form-group">
    <?= Html::label($model->attributeLabels()['representative_id'], 'representative_id') ?>
    <?= Html::dropDownList('Order[representative_id]', $model->representative_id, $model->patient->getRepresentativeList(), ['class' => 'form-control', 'prompt' => '[Не выбрано]']) ?>
</div>
