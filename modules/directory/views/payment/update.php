<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\Payment */

$this->title = 'Редактировать форму оплаты: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Формы оплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="payment-update">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
