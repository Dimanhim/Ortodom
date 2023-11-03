<?php

use yii\helpers\Html;
$i = 0;
?>
<div class="outfit-container">
    <h3>Операционный лист</h3>
</div>
<div style="page-break-after: always;"></div>
<?php foreach($orders as $order) : ?>
<?php //if($i == 0) : ?>
<?= $this->render('operation-list-item', ['order' => $order]) ?>
<div style="page-break-after: always;"></div>
<?php //endif; ?>
<?php $i++; endforeach; ?>
