<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\directory\models\ShoesHeel;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\directory\models\ShoesHeelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задники обуви';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoes-heel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить задник обуви', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            /*[
                'attribute' => 'side',
                'filter' => ShoesHeel::getSideArray(),
                'value' => function($data) {
                    return $data->sideName;
                }
            ],*/
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
