<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $page common\models\Page */
/* @var $model object */

$this->title = 'Добавление страницы';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['/pages']];
$this->params['breadcrumbs'][] = ['label' => $page->typeTitle, 'url' => ['index', 'type' => $page->type]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'page' => $page,
        'model' => $model,
    ]) ?>
</div>
