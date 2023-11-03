<?php

use app\models\Page;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use himiklab\sortablegrid\SortableGridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type string */

$this->title = Page::getTitleOfType($type, 'Страницы');
if ($this->title !== 'Страницы') {
    $this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['/pages']];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Добавить страницу', ['create', 'type' => $type], ['class' => 'btn btn-success']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width: 75px;'],
            ],
            'name',
            'alias',
            [
                'attribute' => 'parent',
                'value' => 'parent.name',
                'filter' => ArrayHelper::map(Page::getList(), 'name', 'name'),
            ],
            /*
            [
                'attribute' => 'parent_id',
                'value' => function($data) {
                    if($data->parent) return $data->parent->name;
                },
                'filter' => ArrayHelper::map(Page::getList(), 'id', 'name'),
            ],
            */
            //'h1',
            //'title',
            //'meta_description',
            //'meta_keywords',
            //'type',
            //'relation_id',
            //'template',
            [
                'attribute' => 'is_active',
                'format' => 'boolean',
                'headerOptions' => ['style' => 'width: 75px;'],
                'filter' => [1 => 'Да', 0 => 'Нет'],
            ],
            //'created_at',
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'headerOptions' => ['style' => 'width: 200px;'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 75px;'],
                'template' => '{view} {update} {toggle-visibility}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        /** @var Page $model */
                        $fullUri = $model->getFrontFullUri();
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $fullUri, ['target' => '_blank']);
                    },
                    'toggle-visibility' => function ($url, $model, $key) {
                        /** @var Page $model */
                        return $model->is_active ? Html::a('<span class="glyphicon glyphicon-remove"></span>', $url) : Html::a('<span class="glyphicon glyphicon-ok"></span>', $url);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
