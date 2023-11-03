<?php

/* @var $this yii\web\View */
/* @var $page common\models\Page */
/* @var $model object */

$this->title = 'Редактирование страницы: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['/pages']];
$this->params['breadcrumbs'][] = ['label' => $page->typeTitle, 'url' => ['index', 'type' => $page->type]];
$this->params['breadcrumbs'][] = $page->name;
?>

<div class="page-update">
    <h1><?= $this->title ?></h1>
    <?= $this->render('_form', [
        'page' => $page,
        'model' => $model,
    ]) ?>
</div>
