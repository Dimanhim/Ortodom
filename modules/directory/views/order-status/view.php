<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\OrderStatus */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статусы заказов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-status-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить статус заказа?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'styles',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->styles ? '<div style="padding: 10px;'.$data->styles.'">'.$data->styles.'</div>' : '';
                }
            ],
            [
                'attribute' => 'show_journal',
                'value' => function($data) {
                    return $data->show_journal ? 'Да' : 'Нет';
                }
            ],
        ],
    ]) ?>

</div>
