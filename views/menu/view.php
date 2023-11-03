<?php

use app\models\MenuItem;
use app\models\Page;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\grid\GridView;
use kartik\widgets\Select2;
use himiklab\sortablegrid\SortableGridView;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $menuItem common\models\MenuItem */
/* @var $menuItems ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="menu-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>

<!--
<div class="menu-item-index">
    <h2>Пункты меню</h2>
    <p>
        <?= Html::a('Добавить пункт', ['create-item', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= SortableGridView::widget([
        'dataProvider' => $menuItems,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function($data) {
                    /** @var $data MenuItem */
                    return Html::a($data->link, $data->link, ['target' => '_blank']);
                },
            ],
            // 'position',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update-item} {delete-item}',
                'buttons' => [
                    'update-item' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['class' => 'action-btn action-btn-2x']);
                    },
                    'delete-item' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-confirm' => 'Вы уверены?', 'class' => 'action-btn action-btn-2x']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
-->


<div class="menu-items">
    <h2>Пункты меню</h2>
    <div class="row">
        <div class="col-md-6">
            <div id="menu-items-tree" data-menu_id="<?= $model->id ?>"></div>
        </div>
        <div class="col-md-6">
            <?php $form = ActiveForm::begin([
                'id' => 'menu-item-form',
                'action' => Url::to(['menu-items/create']),
                'enableAjaxValidation' => true,
                'validationUrl' => Url::to(['menu-items/validate']),
            ]); ?>
                <?= $form->field($menuItem, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($menuItem, 'menu_id')->hiddenInput()->label(false) ?>
            <?= $form->field($menuItem, 'page_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Page::find()->orderBy('id ASC')->all(), 'id', function($item) {
                    return $item->name.' ('.$item->id.')';
                }),
                'options' => ['placeholder' => 'Выберите страницу'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
