<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\ShoesMaterial */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Материалы верха', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoes-material-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'color_ids',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getModelColorsString();
                }
            ],
            'created_at:datetime',
        ],
    ]) ?>

</div>
