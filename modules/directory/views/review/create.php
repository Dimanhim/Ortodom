<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\Review */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
