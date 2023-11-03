<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MenuItem */

$this->title = 'Редактирование пункта: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->menu->name, 'url' => ['menu/view', 'id' => $model->menu_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-item-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
